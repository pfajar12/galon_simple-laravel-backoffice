<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\OrderLog;
use App\Helpers\ApiResponse;
use DB;
use Validator;

class OrderController extends Controller
{
    function create_order(Request $request)
    {
        if($request->current_location==1){
            $validator = Validator::make($request->all(), [
                'current_location'   => 'required',
                'address'            => 'required',
                'lat'                => 'required',
                'lng'                => 'required',
                'depot_id'           => 'required',
                'galon_type'         => 'required',
                'qty'                => 'required',
            ]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'current_location'   => 'required',
                'depot_id'           => 'required',
                'galon_type'         => 'required',
                'qty'                => 'required',
            ]);
        }

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

    	if($request->json('current_location')==1){
    		$address = $request->json('address');
    		$lat 	 = $request->json('lat');
    		$long 	 = $request->json('lng');
    	}
    	else{
    		$address = $request->user()->address;
    		$lat 	 = $request->user()->latitude;
    		$long 	 = $request->user()->longitude;
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
        $validator = Validator::make($request->all(), [
            'limit'   => 'required',
            'offset'  => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

    	$data = DB::table('order AS a')
    				->join('users AS b', 'a.provider_id', '=', 'b.id')
    				->join('tipe_galon AS c', 'a.galon_type', '=', 'c.id')
    				->select('a.id AS order_id', 'a.qty', 'a.delivered_address', 'a.created_at', 'b.fullname AS depot_name', 'c.galon_type_name')
    				->where('a.client_id', $request->user()->id)
    				->orderBy('a.created_at', 'desc')
                    ->skip($request->offset)
                    ->take($request->limit)
    				->get();
        return ApiResponse::response(['success'=>1, 'order'=>$data]);
    }

    function order_list_depot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit'   => 'required',
            'offset'  => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

    	$data = DB::table('order AS a')
    				->join('users AS b', 'a.client_id', '=', 'b.id')
    				->join('tipe_galon AS c', 'a.galon_type', '=', 'c.id')
    				->select('a.id AS order_id', 'a.qty', 'a.delivered_address', 'a.created_at', 'b.fullname AS client_name', 'c.galon_type_name')
    				->where('a.provider_id', $request->user()->id)
    				->orderBy('a.created_at', 'desc')
                    ->skip($request->offset)
                    ->take($request->limit)
    				->get();
        return ApiResponse::response(['success'=>1, 'order'=>$data]);
    }

    function approve_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

    	$order_id = $request->json('order_id');
    	$order = Order::find($order_id);

    	if($request->user()->id == $order->provider_id){
    		// insert into order log
    		$order_log 						= new OrderLog;
    		$order_log->client_id 			= $order->client_id;
    		$order_log->galon_provider_id 	= $order->provider_id;
    		$order_log->order_date 			= $order->created_at;
    		$order_log->galon_type_id 		= $order->galon_type;
    		$order_log->qty 				= $order->qty;
    		$order_log->delivered_address 	= $order->delivered_address;
    		$order_log->delivered_lat 		= $order->delivered_lat;
    		$order_log->delivered_long 		= $order->delivered_long;
    		$order_log->status 				= 1;
    		$order_log->save();

    		// // kurangi total deposit depot
    		$depot_id = $order->provider_id;
    		$qty = $order->qty;
    		$depot = User::select('id', 'deposit')->find($depot_id);
    		$hasil_deposit = $depot->deposit - (500 * $qty);

    		if($hasil_deposit <= 0){
    			$total_deposit = 0;
    		}
    		else{
    			$total_deposit = $hasil_deposit;
    		}

    		$depot->deposit = $total_deposit;
    		$depot->save();

    		// hapus dari table order
    		$order->delete();

	        return ApiResponse::response(['success'=>1, 'message'=>'approve orderan berhasil']);
	    }
	    else{
	        return ApiResponse::response(['success'=>0, 'message'=>'anda tidak berhak atas orderan ini']);
	    }
    }

    function cancel_order(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'order_id'              => 'required',
            'reason_for_cancel' 	=> 'required|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

    	$order_id = $request->json('order_id');
    	$reason = $request->json('reason_for_cancel');
    	$order = Order::find($order_id);

    	if($request->user()->id == $order->provider_id){
    		// insert into order log
    		$order_log 							= new OrderLog;
    		$order_log->client_id 				= $order->client_id;
    		$order_log->galon_provider_id 		= $order->provider_id;
    		$order_log->order_date 				= $order->created_at;
    		$order_log->galon_type_id 			= $order->galon_type;
    		$order_log->qty 					= $order->qty;
    		$order_log->delivered_address 		= $order->delivered_address;
    		$order_log->delivered_lat 			= $order->delivered_lat;
    		$order_log->delivered_long 			= $order->delivered_long;
    		$order_log->status 					= -1;
    		$order_log->reason_for_canceling 	= $request->json('reason_for_cancel');
    		$order_log->save();

    		// hapus dari table order
    		$order->delete();

	        return ApiResponse::response(['success'=>0, 'message'=>'cancel orderan berhasil']);
    	}
    	else{
	        return ApiResponse::response(['success'=>0, 'message'=>'anda tidak berhak atas orderan ini']);
	    }
    }
	    	
    function order_log_client(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit'   => 'required',
            'offset'  => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

    	$client_id = $request->user()->id;
    	$data = DB::table('order_log AS a')
    				->join('users AS b', 'a.galon_provider_id', '=', 'b.id')
    				->join('tipe_galon AS c', 'a.galon_type_id', '=', 'c.id')
    				->select('a.id AS order_log_id', 'a.qty', 'a.delivered_address', 'a.status', 'a.created_at', 'b.fullname AS depot_name', 'c.galon_type_name')
    				->where('a.client_id', $client_id)
    				->orderBy('a.created_at', 'desc')
                    ->skip($request->offset)
                    ->take($request->limit)
    				->get();
        return ApiResponse::response(['success'=>0, 'data'=>$data]);
    }

    function order_log_depot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit'   => 'required',
            'offset'  => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }
        
    	$depot_id = $request->user()->id;
    	$data = DB::table('order_log AS a')
    				->join('users AS b', 'a.client_id', '=', 'b.id')
    				->join('tipe_galon AS c', 'a.galon_type_id', '=', 'c.id')
    				->select('a.id AS order_log_id', 'a.qty', 'a.delivered_address', 'a.status', 'a.created_at', 'b.fullname AS client_name', 'c.galon_type_name')
    				->where('a.galon_provider_id', $depot_id)
    				->orderBy('a.created_at', 'desc')
                    ->skip($request->offset)
                    ->take($request->limit)
    				->get();
        return ApiResponse::response(['success'=>0, 'data'=>$data]);
    }

    function search_depot(Request $request)
    {
        $lat        = $request->json('lat') ;
        $long       = $request->json('lng');
        $galon_type = $request->json('galon_type');
        $qty        = $request->json('qty');

        $validator = Validator::make($request->all(), [    
            'lat'           => 'required',
            'lng'           => 'required',
            'galon_type'    => 'required',
            'qty'           => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

        $getId = DB::table('tipe_galon_user')->select('user_id')->where('galon_type_id', $galon_type)->pluck('user_id');

        $notExceedThanLimit = DB::table('order')->select('provider_id', DB::raw('count(provider_id) as total'))->groupBy('provider_id')->havingRaw('total >= 3')->pluck('provider_id');

        $data = User::query()
                    ->select('*', DB::raw('( 6371 * acos( cos( radians('.$lat.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$long.') ) + sin( radians('.$lat.') ) * sin( radians( latitude ) ) ) ) AS distance'))        
                    ->where('status', 1)
                    ->where('role', 3)
                    ->where('deposit', '>', 0)
                    ->whereIn('id', $getId)
                    ->whereNotIn('id', $notExceedThanLimit)
                    ->orderBy('distance', 'asc')
                    ->first();
        return ApiResponse::response(['success'=>0, 'data'=>$data]);
    }
    	
}
