<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepotGalonController extends Controller
{
    function __construct()
	{
		$this->page = 'depot-galon';
	}

	function index($value='')
    {
    	return view('pages/admin/depotgalon/index', ['page'=>$this->page]);
    }
}
