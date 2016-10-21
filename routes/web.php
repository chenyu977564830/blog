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



Route::any('/', 'Home\IndexController@index');
Route::any('art', 'Home\IndexController@article');
Route::any('list', 'Home\IndexController@articleList');



Route::any('admin/login', 'Admin\LoginController@login');
Route::get('admin/code', 'Admin\LoginController@code');
Route::get('admin/encrypt', 'Admin\LoginController@encrypt');

//后台路由
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware' => 'admin.login'], function () {
    Route::get('index', 'IndexController@index');
	Route::get('info', 'IndexController@info');
	Route::get('quit', 'LoginController@quit');
	Route::any('pass', 'IndexController@pass');
	
	Route::post('category/order', 'CategoryController@order');
	Route::post('link/order', 'LinkController@order');
	Route::post('nav/order', 'NavController@order');
	Route::post('conf/order', 'ConfController@order');
	Route::post('conf/confUpdate', 'ConfController@confUpdate');
	
	Route::post('upload', 'CommonController@upload');
	
	Route::get('cate/{cate_id}/{keywords}', 'ArticleController@index');
	Route::post('article/delMuch', 'ArticleController@delMuch');
	Route::resource('category', 'CategoryController');
	Route::resource('article', 'ArticleController');
	Route::resource('link', 'LinkController');
	Route::resource('nav', 'NavController');
	Route::resource('conf', 'ConfController');
});
