<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TipeGalon;
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

    function store($value='', Request $request)
    {
        $tipegalon = new TipeGalon;
        $tipegalon->galon_type_name = $request->tipe_galon;
        $tipegalon->status = 1;

        $success = $tipegalon->save();

        if($success){
          return "success";
        }
    }

    function setnonactive($id='')
    {
        $tipegalon = TipeGalon::findOrFail($id);
        $tipegalon->status = 0;
        $tipegalon->save();
        return "success";
    }

    function restore($id='', Request $request)
    {
        $tipegalon = TipeGalon::findOrFail($id);
        $tipegalon->status = 1;
        $tipegalon->save();

        $request->session()->flash('alert-success', 'Tipe galon berhasil diaktifkan');
        return redirect()->route('admin.tipegalon');
    }
}
