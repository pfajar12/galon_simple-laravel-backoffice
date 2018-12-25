<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\User;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class LoginController extends Controller
{
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [    
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::response(['success'=>-1, 'message'=>$validator->errors()->getMessages()]);
        }

        $credentials = [
            'email' => strtolower($request->email),
            'password' => $request->password
        ];

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return ApiResponse::response(['success'=>0, 'message'=>'invalid credentials']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return ApiResponse::response(['success'=>-2, 'message'=>'server error']);
        }

        // check user active
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->status != 1) {
                return ApiResponse::response(['success'=>-1, 'message'=>'Your account has not been activated yet. Please wait or contact admin']);
            }
        }

        // all good so return the token
        return ApiResponse::response(['success'=>1, 'token'=>$token, 'data'=>Auth::user()]);
    }
}
