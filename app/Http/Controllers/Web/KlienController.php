<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KlienController extends Controller
{
    function __construct()
	{
		$this->page = 'klien';
	}

	function index($value='')
    {
    	return view('pages/admin/klien/index', ['page'=>$this->page]);
    }
}
