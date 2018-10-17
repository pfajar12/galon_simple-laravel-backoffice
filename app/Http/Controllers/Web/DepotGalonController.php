<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use DB;

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

    function get_data($id='', Request $request)
    {
        $field = $request->field;
        $deposit = User::select($field)->where('id', $id)->first();
        return $deposit->deposit;
    }

    function set_deposit(Request $request)
    {
        $id = $request->id;
        $nilai_deposit = $request->nilai_deposit;

        $get_current_deposit = User::select('deposit')->where('id', $id)->first();
        $current_deposit = $get_current_deposit->deposit;

        $new_deposit = $current_deposit + $nilai_deposit;

        // set deposit amount
        $deposit_amount = User::find($id);
        $deposit_amount->deposit = $new_deposit;
        $deposit_amount->save();

        // set deposit log
        DB::table('deposit_log')
            ->insert([
                'depot_id' => $id,
                'approved_by' => Auth::user()->id,
                'deposit_amount' => $nilai_deposit,
                'created_at' => Carbon::now()
            ]);

        return $new_deposit;
    }
}
