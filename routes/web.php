<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get("/show/my/page",function (){
   return view("my_page");
});

Route::get('/dashboard','Admin\HomeController@index');
Route::get('/user/list','Admin\UserController@index');
Route::get('/user/create','Admin\UserController@create');
Route::get('/user/edit','Admin\UserController@edit');
Route::get('/admin/login','Auth\LoginController@showLoginForm');
