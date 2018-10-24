<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    function __construct()
	{
		$this->page = 'order-list';
	}

	function index($value='')
	{
		return view('pages/admin/order/orderlist', ['page'=>$this->page]);
	}

	function order_log($value='')
	{
		return view('pages/admin/order/orderlog', ['page'=>'order-log']);
	}
}
