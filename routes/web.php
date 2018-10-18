<?php


Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role']], function () {

	// DASHBOARD
	Route::get('/dashboard', 'web\DashboardController@index')->name('admin.dashboard');

    Route::get('/serverside-registered-client', [
        'as'   => 'serverside-registered-client',
        'uses' => function () {
            $data = DB::table('users')
                        ->select('fullname', 'email', 'created_at')
                        ->where([['role', 4], ['status', 1]]);
            return datatables()->query($data)->toJson();
        }
    ]);

    Route::get('/serverside-registered-depotgalon', [
        'as'   => 'serverside-registered-depotgalon',
        'uses' => function () {
            $data = DB::table('users')
                        ->select('fullname', 'email', 'deposit', 'created_at')
                        ->where([['role', 3], ['status', 1]]);
            return datatables()->query($data)->toJson();
        }
    ]);


	// KLIEN
    Route::get('/klien', 'web\KlienController@index')->name('admin.klien');
    Route::get('/klien/{id}/view', 'web\KlienController@show_detail')->name('admin.klien.view');
    Route::get('/klien/{id}/set-aktif', 'web\KlienController@set_aktif')->name('admin.klien.setaktif');
    Route::get('/klien/{id}/set-suspend', 'web\KlienController@set_suspend')->name('admin.klien.setsuspend');

	Route::get('/serverside-klien', [
        'as'   => 'serverside-klien',
        'uses' => function () {
            $data = DB::table('users')
            			->select('fullname', 'email', 'created_at', 'id')
            			->where([['role', 4], ['status', 1]]);
            return datatables()->query($data)->toJson();
        }
    ]);

    Route::get('/serverside-klien-pendaftar', [
        'as'   => 'serverside-klien-pendaftar',
        'uses' => function () {
            $data = DB::table('users')
            			->select('fullname', 'email', 'created_at', 'id')
            			->where([['role', 4], ['status', 0]]);
            return datatables()->query($data)->toJson();
        }
    ]);

    Route::get('/serverside-klien-tersuspend', [
        'as'   => 'serverside-klien-tersuspend',
        'uses' => function () {
            $data = DB::table('users')
                        ->select('fullname', 'email', 'id')
                        ->where([['role', 4], ['status', -1]]);
            return datatables()->query($data)->toJson();
        }
    ]);


    // DEPOT GALON
    Route::get('/depot-galon', 'web\DepotGalonController@index')->name('admin.depotgalon');
    Route::get('/depot-galon/{id}/view', 'web\DepotGalonController@show_detail')->name('admin.depotgalon.view');
    Route::get('/depot-galon/{id}/set-aktif', 'web\DepotGalonController@set_aktif')->name('admin.depotgalon.setaktif');
    Route::get('/depot-galon/{id}/set-suspend', 'web\DepotGalonController@set_suspend')->name('admin.depotgalon.setsuspend');
    Route::get('/depot-galon/{id}/get-data', 'web\DepotGalonController@get_data')->name('admin.depotgalon.getdata');
    Route::post('/depot-galon/{id}/set-deposit', 'web\DepotGalonController@set_deposit')->name('admin.depotgalon.setdeposit');
	
    Route::get('/serverside-depotgalon', [
        'as'   => 'serverside-depotgalon',
        'uses' => function () {
            $data = DB::table('users')
                        ->select('fullname', 'email', 'created_at', 'id')
                        ->where([['role', 3], ['status', 1]]);
            return datatables()->query($data)->toJson();
        }
    ]);

    Route::get('/serverside-depotgalon-pendaftar', [
        'as'   => 'serverside-depotgalon-pendaftar',
        'uses' => function () {
            $data = DB::table('users')
                        ->select('fullname', 'email', 'created_at', 'id')
                        ->where([['role', 3], ['status', 0]]);
            return datatables()->query($data)->toJson();
        }
    ]);

    Route::get('/serverside-depotgalon-tersuspend', [
        'as'   => 'serverside-depotgalon-tersuspend',
        'uses' => function () {
            $data = DB::table('users')
                        ->select('fullname', 'email', 'created_at', 'id')
                        ->where([['role', 3], ['status', -1]]);
            return datatables()->query($data)->toJson();
        }
    ]);


    // TIPE GALON
    Route::get('/tipe-galon', 'web\TipeGalonController@index')->name('admin.tipegalon');
    Route::post('/tipe-galon', 'web\TipeGalonController@store')->name('admin.tipegalon.store');
    Route::get('/tipe-galon/{id}/setnonactive', 'web\TipeGalonController@setnonactive')->name('admin.tipegalon.setnonactive');
    Route::get('/tipe-galon/{id}/restore', 'web\TipeGalonController@restore')->name('admin.tipegalon.restore');


    // LOG DEPOSIT
    Route::get('/log-deposit', 'web\DepositLogController@index')->name('admin.logdeposit');
    Route::get('/log-deposit/{id}/get', 'web\DepositLogController@get_per_depot')->name('admin.logdeposit.perdepot');
    
    Route::get('/serverside-log-deposit', [
        'as'   => 'serverside-log-deposit',
        'uses' => function () {
            $data = DB::table('deposit_log')
                        ->join('users AS depot', 'deposit_log.depot_id', '=', 'depot.id')
                        ->join('users AS admin', 'deposit_log.approved_by', '=', 'admin.id')
                        ->select('depot.fullname AS depot_name', 'deposit_log.deposit_amount', 'admin.fullname AS approved_by', 'deposit_log.created_at');
            return datatables()->query($data)->toJson();
        }
    ]);
});

