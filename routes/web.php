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
/*group middleware*/
/*Route::group(['middleware'=>'auth'],function (){*/
    Route::get('/dashboard','Admin\HomeController@index')/*->middleware('auth')*/;
    Route::get('/user/list','Admin\UserController@index')/*->middleware('auth')*/;
    Route::get('/user/create','Admin\UserController@create') /*->middleware('auth')*/;
    Route::get('/user/edit','Admin\UserController@edit')/*->middleware('auth')*/;
/*});*/
/* Login Route */
Route::get('/user/login','Auth\LoginController@showLoginForm');
Route::post('/user/login','Auth\LoginController@login')->name('user.login');
Route::post('/user/logout','Auth\LoginController@logout')->name('user.logout');
/* Registration Route */
Route::get('/user/registration','Auth\RegisterController@showRegistrationForm');
Route::post('/user/register','Auth\RegisterController@userRegister')->name('user.register');