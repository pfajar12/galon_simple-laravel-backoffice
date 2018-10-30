<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['api']], function(){

	// register
	Route::post('/register', 'Api\RegisterController@register');

	// login
	Route::post('/login', 'Api\LoginController@login');

	// depot list
	Route::get('/depot-list', 'Api\DepotController@show_list');
	
	// search depot
	Route::post('/search-depot', 'Api\OrderController@search_depot');

	Route::group(['middleware' => ['jwt.auth']], function(){

		// profile
		Route::get('/profile', 'Api\UserController@profile');
		Route::post('/profile-update', 'Api\UserController@profile_update');
		Route::post('/change-location', 'Api\UserController@change_location');
		Route::post('/set-galon-type', 'Api\UserController@set_galon_type');

		// order
		Route::post('/order', 'Api\OrderController@create_order');
		Route::get('/order-list-client', 'Api\OrderController@order_list_client');
		Route::get('/order-list-depot', 'Api\OrderController@order_list_depot');
		Route::post('/approve-order', 'Api\OrderController@approve_order');
		Route::post('/cancel-order', 'Api\OrderController@cancel_order');
		Route::get('/order-log-client', 'Api\OrderController@order_log_client');
		Route::get('/order-log-depot', 'Api\OrderController@order_log_depot');

	});

});
