<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

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

    function show_detail($id='')
    {
        $data = User::select('fullname', 'email', 'status', 'address', 'deposit', 'phone', 'lat', 'long', 'created_at')->findOrFail($id);
        return view('pages/admin/depotgalon/detail', ['page'=>$this->page, 'galon'=>$data, 'galon_id'=>$id]);
    }

    function set_aktif($id='', Request $request)
    {
        $klien = User::findOrFail($id);
        $klien->status = 1;
        $klien->save();

        $request->session()->flash('alert-success', 'Depot galon berhasil diaktifkan');
        return redirect()->route('admin.depotgalon');
    }

    function set_suspend($id='')
    {
        $klien = User::findOrFail($id);
        $klien->status = -1;
        $klien->save();
        return "success";
    }
}
