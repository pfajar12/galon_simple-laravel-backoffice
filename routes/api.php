<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['api']], function(){

	// register
	Route::post('/register', 'api\RegisterController@register');

	// login
	Route::post('/login', 'api\LoginController@login');

	Route::group(['middleware' => ['jwt.auth']], function(){

		Route::get('/profile', 'api\UserController@profile');

	});

});
