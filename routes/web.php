<?php


Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role']], function () {

	// DASHBOARD
	Route::get('/dashboard', 'Web\DashboardController@index')->name('admin.dashboard');

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
    Route::get('/klien', 'Web\KlienController@index')->name('admin.klien');
    Route::get('/klien/{id}/view', 'Web\KlienController@show_detail')->name('admin.klien.view');
    Route::get('/klien/{id}/set-aktif', 'Web\KlienController@set_aktif')->name('admin.klien.setaktif');
    Route::get('/klien/{id}/set-suspend', 'Web\KlienController@set_suspend')->name('admin.klien.setsuspend');

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
    Route::get('/depot-galon', 'Web\DepotGalonController@index')->name('admin.depotgalon');
    Route::get('/depot-galon/{id}/view', 'Web\DepotGalonController@show_detail')->name('admin.depotgalon.view');
    Route::get('/depot-galon/{id}/set-aktif', 'Web\DepotGalonController@set_aktif')->name('admin.depotgalon.setaktif');
    Route::get('/depot-galon/{id}/set-suspend', 'Web\DepotGalonController@set_suspend')->name('admin.depotgalon.setsuspend');
    Route::get('/depot-galon/{id}/get-data', 'Web\DepotGalonController@get_data')->name('admin.depotgalon.getdata');
    Route::post('/depot-galon/{id}/set-deposit', 'Web\DepotGalonController@set_deposit')->name('admin.depotgalon.setdeposit');
	
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
    Route::get('/tipe-galon', 'Web\TipeGalonController@index')->name('admin.tipegalon');
    Route::post('/tipe-galon', 'Web\TipeGalonController@store')->name('admin.tipegalon.store');
    Route::get('/tipe-galon/{id}/setnonactive', 'Web\TipeGalonController@setnonactive')->name('admin.tipegalon.setnonactive');
    Route::get('/tipe-galon/{id}/restore', 'Web\TipeGalonController@restore')->name('admin.tipegalon.restore');


    // LOG DEPOSIT
    Route::get('/log-deposit', 'Web\DepositLogController@index')->name('admin.logdeposit');
    Route::get('/log-deposit/{id}/get', 'Web\DepositLogController@get_per_depot')->name('admin.logdeposit.perdepot');
    
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


    // ORDER
    Route::get('/order-list', 'Web\OrderController@index')->name('admin.orderlist');

    Route::get('/serverside-order-list', [
        'as'   => 'serverside-order-list',
        'uses' => function () {
            $data = DB::table('order')
                        ->join('users AS client', 'order.client_id', '=', 'client.id')
                        ->join('users AS depot', 'order.provider_id', '=', 'depot.id')
                        ->join('tipe_galon', 'order.galon_type', '=', 'tipe_galon.id')
                        ->select('client.fullname AS client_name', 'depot.fullname AS depot_name', 'tipe_galon.galon_type_name', 'order.qty', 'order.created_at');
            return datatables()->query($data)->toJson();
        }
    ]);


    // ORDER LOG
    Route::get('/order-log', 'Web\OrderController@order_log')->name('admin.orderlog');

    Route::get('/serverside-order-log', [
        'as'   => 'serverside-order-log',
        'uses' => function () {
            $data = DB::table('order_log')
                        ->join('users AS client', 'order_log.client_id', '=', 'client.id')
                        ->join('users AS depot', 'order_log.galon_provider_id', '=', 'depot.id')
                        ->join('tipe_galon', 'order_log.galon_type_id', '=', 'tipe_galon.id')
                        ->select('client.fullname AS client_name', 'depot.fullname AS depot_name', 'tipe_galon.galon_type_name', 'order_log.qty', 'order_log.order_date', 'order_log.status');
            return datatables()->query($data)->toJson();
        }
    ]);
});

