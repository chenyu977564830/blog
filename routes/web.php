<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::any('admin/login', 'Admin\LoginController@login');
Route::get('admin/code', 'Admin\LoginController@code');
Route::get('admin/encrypt', 'Admin\LoginController@encrypt');

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware' => 'admin.login'], function () {
    Route::get('index', 'IndexController@index');
	Route::get('info', 'IndexController@info');
	Route::get('quit', 'LoginController@quit');
	Route::any('pass', 'IndexController@pass');
	Route::resource('category', 'CategoryController');
});