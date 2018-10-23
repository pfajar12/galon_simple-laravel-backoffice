<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\User;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function profile(Request $request)
    {   
        $id = $request->user()->id;
        $user = User::find($id);
        return ApiResponse::response(['success'=>1, 'user'=>$user]);
    }

    function profile_update(Request $request)
    {
    	$validatedData = $request->validate([
            'fullname' 	=> 'required|string',
            'address' 	=> 'required|string',
            'phone' 	=> 'required|string',
        ]);

    	$id = $request->user()->id;

        $user = User::find($id);
        $user->fullname = $request->json('fullname');
        $user->address = $request->json('address');
        $user->phone = $request->json('phone');
        $user->save();

        return ApiResponse::response(['success'=>1, 'message'=>'update profile berhasil']);
    }

    function change_location(Request $request)
    {
    	$validatedData = $request->validate([
            'address' 	=> 'required|string',
        ]);

    	$id = $request->user()->id;

        $user = User::find($id);
        $user->address = $request->json('address');
        $user->lat = $request->json('lat');
        $user->long = $request->json('long');
        $user->save();

        return ApiResponse::response(['success'=>1, 'message'=>'update lokasi berhasil']);
    }

    function set_galon_type(Request $request)
    {
    	$id = $request->user()->id;
    	$galon_type = $request->json('galon_type');
    	$dataLength = count($galon_type);

    	for($i=0; $i<$dataLength; $i++){
    		DB::table('tipe_galon_user')
    			->insert([
    				'user_id' => $id,
    				'galon_type_id' => $galon_type[$i],
					'created_at' => Carbon::now()
				]);
    	}


        return ApiResponse::response(['success'=>1, 'message'=>'set tipe galon berhasil']);
    }
}
