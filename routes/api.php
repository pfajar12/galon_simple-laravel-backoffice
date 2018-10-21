<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['api']], function(){

	// register
	Route::post('/register', 'api\RegisterController@register');

	// login
	Route::post('/login', 'api\LoginController@login');

	// depot list
	Route::get('/depot-list', 'api\DepotController@show_list');
	

	Route::group(['middleware' => ['jwt.auth']], function(){

		// view own profile
		Route::get('/profile', 'api\UserController@profile');

		// order
		Route::post('/order', 'api\OrderController@create_order');
		Route::get('/order-list-client', 'api\OrderController@order_list_client');
		Route::get('/order-list-depot', 'api\OrderController@order_list_depot');
		Route::post('/approve-order', 'api\OrderController@approve_order');
		Route::post('/cancel-order', 'api\OrderController@cancel_order');
		Route::get('/order-log-client', 'api\OrderController@order_log_client');
		Route::get('/order-log-depot', 'api\OrderController@order_log_depot');

	});

});
