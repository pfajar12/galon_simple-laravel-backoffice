<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class TipeGalonController extends Controller
{
    function __construct()
	{
		$this->page = 'tipe-galon';
	}

	function index($value='')
    {
    	$tipegalon_aktif = DB::table('tipe_galon')->select('id', 'galon_type_name')->where('status', 1)->get();
    	$tipegalon_nonaktif = DB::table('tipe_galon')->select('id', 'galon_type_name')->where('status', 0)->get();
    	return view('pages/admin/tipegalon/index', ['page'=>$this->page, 'tipegalon_aktif'=>$tipegalon_aktif, 'tipegalon_nonaktif'=>$tipegalon_nonaktif]);
    }
}
