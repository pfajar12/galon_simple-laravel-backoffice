<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    function __construct()
	{
		$this->page = 'dashboard';
	}

	function index($value='')
    {
    	$registered_client = DB::table('users')
		            			->select('id')
		            			->where([['role', 4], ['status', 0]])
		            			->count();

		$approved_client = DB::table('users')
		            			->select('id')
		            			->where([['role', 4], ['status', 1]])
		            			->count();

		$today_client = DB::table('users')
		            			->select('id')
		            			->where([['role', 4], ['status', 1]])
		            			->whereDate('created_at', Carbon::today())
		            			->count();

		$registered_depot_galon = DB::table('users')
		            			->select('id')
		            			->where([['role', 3], ['status', 0]])
		            			->count();

		$approved_depot_galon = DB::table('users')
		            			->select('id')
		            			->where([['role', 3], ['status', 1]])
		            			->count();

		$today_depot_galon = DB::table('users')
		            			->select('id')
		            			->where([['role', 3], ['status', 1]])
		            			->whereDate('created_at', Carbon::today())
		            			->count();

    	return view('pages/admin/dashboard/index', ['page'=>$this->page, 'registered_client_count'=>$registered_client, 'registered_depot_galon_count'=>$registered_depot_galon, 'approved_client'=>$approved_client, 'today_client'=>$today_client, 'approved_depot_galon'=>$approved_depot_galon, 'today_depot_galon'=>$today_depot_galon]);
    }
}
