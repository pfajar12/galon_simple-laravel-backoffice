<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DepositLogController extends Controller
{
	function __construct()
	{
		$this->page = 'log-deposit';
	}

	function index($value='')
	{
		return view('pages/admin/logdeposit/index', ['page'=>$this->page]);
	}

    function get_per_depot($id='')
    {
    	$data = DB::table('deposit_log')
		    		->join('users', 'deposit_log.approved_by', '=', 'users.id')
		    		->select('users.fullname', 'deposit_log.deposit_amount', 'deposit_log.created_at')
		    		->where('deposit_log.depot_id', $id)
		    		->orderBy('deposit_log.created_at', 'desc')
		    		->get();
		return $data;
    }
}
