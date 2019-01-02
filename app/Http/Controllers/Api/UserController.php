<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\User;
use App\TipeGalon;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Hash;

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
        $validator = Validator::make($request->all(), [    
            'fullname'  => 'required|string',
            'address'   => 'required|string',
            'phone'     => 'required|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

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
        $validator = Validator::make($request->all(), [    
            'address'   => 'required|string',
            'lat'       => 'required',
            'lng'       => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

    	$id = $request->user()->id;

        $user = User::find($id);
        $user->address = $request->json('address');
        $user->latitude = $request->json('lat');
        $user->longitude = $request->json('long');
        $user->save();

        return ApiResponse::response(['success'=>1, 'message'=>'update lokasi berhasil']);
    }

    function set_galon_type(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'galon_type'    => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

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

    public function get_galon_type(Request $request)
    {
        $data = TipeGalon::select('id', 'galon_type_name')->where('status', 1)->get();
        return ApiResponse::response(['success'=>1, 'galon_type'=>$data]);
    }

    public function change_password(Request $request)
    {
        $id = $request->user()->id;
        $validator = Validator::make($request->all(), [    
            'old_password'               => 'required',
            'new_password'               => 'required|confirmed',
            'new_password_confirmation'  => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

        if(Hash::check($request->old_password, Auth::user()->password)){
            $user = User::find($id);
            $user->password = bcrypt($request->new_password);
            $user->save();

            return ApiResponse::response(['success'=>1, 'message'=>'password successfully updated']);
        }
        else{
            return ApiResponse::response(['success'=>-11, 'message'=>'Your old password not matched']);
        }
    }
}
