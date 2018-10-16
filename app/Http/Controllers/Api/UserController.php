<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\User;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function profile(Request $request)
    {   
        $id = $request->user()->id;
        $user = User::find($id);
        return ApiResponse::response(['success'=>1, 'user'=>$user]);
    }
}
