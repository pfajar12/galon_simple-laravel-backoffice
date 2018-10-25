<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\User;

class DepotController extends Controller
{
    function show_list()
    {
    	$data = User::select('fullname', 'address', 'phone', 'business_license_photo', 'latitude', 'longitude')
    				->where([['role', 3], ['status', 1]])
    				->get();
    	return ApiResponse::response(['success'=>1, 'depot_galon'=>$data]);
    }
}
