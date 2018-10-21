<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\OrderLog;
use App\Helpers\ApiResponse;
use DB;

class OrderController extends Controller
{
    function create_order(Request $request)
    {
    	if($request->json('current_location')==1){
    		$address = $request->json('address');
    		$lat 	 = $request->json('lat');
    		$long 	 = $request->json('long');
    	}
    	else{
    		$address = $request->user()->address;
    		$lat 	 = $request->user()->lat;
    		$long 	 = $request->user()->long;
    	}

    	$order = new Order;
    	$order->client_id = $request->user()->id;
    	$order->provider_id = $request->json('depot_id');
    	$order->galon_type = $request->json('galon_type');
    	$order->qty = $request->json('qty');
    	$order->delivered_address = $address;
    	$order->delivered_lat = $lat;
    	$order->delivered_long = $long;
    	$order->save();

    	if($order->save()){
            return ApiResponse::response(['success'=>1, 'message'=>'order berhasil']);
    	}
    }

    function order_list_client(Request $request)
    {
    	$data = DB::table('order AS a')
    				->join('users AS b', 'a.provider_id', '=', 'b.id')
    				->join('tipe_galon AS c', 'a.galon_type', '=', 'c.id')
    				->select('a.id AS order_id', 'a.qty', 'a.delivered_address', 'b.fullname AS depot_name', 'c.galon_type_name')
    				->where('a.client_id', $request->user()->id)
    				->get();
        return ApiResponse::response(['success'=>1, 'order'=>$data]);
    }

    function order_list_depot(Request $request)
    {
    	$data = DB::table('order AS a')
    				->join('users AS b', 'a.client_id', '=', 'b.id')
    				->join('tipe_galon AS c', 'a.galon_type', '=', 'c.id')
    				->select('a.qty', 'a.delivered_address', 'b.fullname AS client_name', 'c.galon_type_name')
    				->where('a.provider_id', $request->user()->id)
    				->get();
        return ApiResponse::response(['success'=>1, 'order'=>$data]);
    }

    function approve_order(Request $request)
    {
    	$order_id = $request->json('order_id');
    	$order = Order::find($order_id);

    	if($request->user()->id == $order->client_id){
    		// insert into order log
    		// $order_log = new OrderLog;
    		// $order_log->client_id = $order->client_id;
    		// $order_log->galon_provider_id = $order->provider_id;
    		// $order_log->order_date = $order->created_at;
    		// $order_log->galon_type_id = $order->galon_type;
    		// $order_log->qty = $order->qty;
    		// $order_log->delivered_address = $order->delivered_address;
    		// $order_log->delivered_lat = $order->delivered_lat;
    		// $order_log->delivered_long = $order->delivered_long;
    		// $order_log->status = 1;
    		// $order_log->reason_for_canceling = $request->json('reason_for_canceling');
    		// $order_log->save();

    		// kurangi total deposit depot
    		$depot_id = $order->provider_id;
    		$depot = User::select('deposit')->find($depot_id);

	        return ApiResponse::response(['success'=>1, 'message'=>'approve orderan berhasil', 'data'=>$depot]);
	    }
	    else{
	        return ApiResponse::response(['success'=>0, 'message'=>'anda tidak berhak atas orderan ini']);
	    }
	    	

    }
    	
}
