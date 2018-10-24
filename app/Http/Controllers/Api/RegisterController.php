<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\ApiResponse;

class RegisterController extends Controller
{
    function register(Request $request)
    {
    	$validatedData = $request->validate([
            'fullname' 	=> 'required|string|max:191',
            'email' 	=> 'required|email|unique:users',
            'password' 	=> 'required|min:6|max:32',
        ]);

        if($request->json('lat')==null){
            $latitude   = 0;
            $longitude  = 0;
        }
        else{
            $latitude   = $request->json('lat');
            $longitude  = $request->json('long');
        }

        $user = new User;
        $user->fullname     = $request->json('fullname');
        $user->email        = $request->json('email');
    	$user->password     = bcrypt($request->json('password'));
        $user->role         = $request->json('role');
        $user->latitude     = $latitude;
    	$user->longitude    = $longitude;
    	$user->status       = 0;
    	$user->deposit      = 0;
    	$user->save();

    	if($user->save()){
            return ApiResponse::response(['success'=>1, 'message'=>'register success']);
        }
    }
}
