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

/*Question Routes*/
Route::get('/new/question','User\QuestionController@create');
Route::post('/store/question','User\QuestionController@store')
    ->name('store.question');
Route::get('/question/list','User\QuestionController@index');
Route::get('/question/datatable','User\QuestionController@questionData');
Route::get('/top/question','User\QuestionController@topQuestion');
Route::get('/show/question/{id}','User\QuestionController@show')->name('show.question');
Route::post('/save/answer/{id}','User\QuestionController@saveAnswer')->name('save.answer');
Route::post('/comment/on/answer/{id}','User\QuestionController@makeComments')->name('comment.on');
Route::get('/delete/comment/{id}','User\QuestionController@deleteComment')->name('delete.comment');
Route::post('/update/answer/{id}','User\QuestionController@updateAnswer');
Route::get('/edit/question/{id}','User\QuestionController@edit')->name('edit.question');
Route::POST('/update/question/{id}','User\QuestionController@update')->name('update.question');
Route::get('/delete/question/{id}','User\QuestionController@destroy')->name('delete.question');

/*Vote Routes*/
Route::get('/vote/{id}','User\QuestionController@vote')->name('vote');
Route::get('/cancel/vote/{id}','User\QuestionController@cancelVote')->name('cancel.vote');