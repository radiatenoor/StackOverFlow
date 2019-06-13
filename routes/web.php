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
/*group middleware*/
/*Route::group(['middleware'=>'auth'],function (){*/
    Route::get('/dashboard','User\HomeController@index')/*->middleware('auth')*/;
/*});*/
/* Login Route */
Route::get('/user/login','Auth\LoginController@showLoginForm');
Route::post('/user/login','Auth\LoginController@login')->name('user.login');
Route::post('/user/logout','Auth\LoginController@logout')->name('user.logout');

Route::get('/user/profile','Auth\LoginController@profile');
Route::post('/update/profile','Auth\LoginController@profileUpdate')->name('update.profile');
Route::post('/change/password','Auth\LoginController@changePassword')->name('change.password');

/* password reset link */
Route::get('/password/reset/form','Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('/send/reset/link','Auth\ForgotPasswordController@sendResetLinkEmail')
    ->name('send.reset.link');
/* password reset request */
Route::get('/password/reset/{token}','Auth\ResetPasswordController@showResetForm')
    ->name('password.reset');
Route::post('/password/reset','Auth\ResetPasswordController@reset')
    ->name('password.request');

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
Route::get('/view/question/{id}','User\QuestionController@view')->name('view.question');
Route::get('/edit/question/{id}','User\QuestionController@edit')->name('edit.question');
Route::POST('/update/question/{id}','User\QuestionController@update')->name('update.question');
Route::get('/delete/question/{id}','User\QuestionController@destroy')->name('delete.question');
/*When use post search this is how we declare a route*/
Route::any('/search/question','User\QuestionController@search')->name('search.question');

/*Vote Routes*/
Route::get('/vote/{id}','User\QuestionController@vote')->name('vote');
Route::get('/cancel/vote/{id}','User\QuestionController@cancelVote')->name('cancel.vote');

/*Answer Route*/
Route::post('/save/answer/{id}','User\AnswerController@saveAnswer')->name('save.answer');
Route::post('/comment/on/answer/{id}','User\AnswerController@makeComments')->name('comment.on');
Route::get('/delete/comment/{id}','User\AnswerController@deleteComment')->name('delete.comment');
Route::post('/update/answer/{id}','User\AnswerController@updateAnswer');
Route::get('/answered/list','User\AnswerController@answeredList');
Route::get('/get/answered/datatable','User\AnswerController@getDataTableAnsweredList');
Route::get('/show/answered/question/{id}','User\AnswerController@showAnsweredQuestion')
    ->name('answered.question');
Route::get('/delete/answer/{id}','User\AnswerController@destroy')->name('delete.answer');

/* Admin Side -------------------------------------------------------------------*/
Route::prefix('admin')->group(function (){

    Route::get('/login','Auth\AdminLoginController@showLoginForm');
    Route::post('/login','Auth\AdminLoginController@login')->name('admin.login');
    Route::post('/logout','Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/dashboard','Admin\HomeController@index');

    /* Forgot Password */
    Route::get('/password/reset/form','Auth\AdminForgotPasswordController@showLinkRequestForm');
    Route::post('/send/reset/link','Auth\AdminForgotPasswordController@sendResetLinkEmail')
        ->name('admin.reset.link');
    /* Reset Password*/
    Route::get('/password/reset/{token}','Auth\AdminResetPasswordController@showResetForm')
        ->name('admin.password.reset');
    Route::post('/password/reset','Auth\AdminResetPasswordController@reset')
        ->name('admin.password.request');
});

Route::get('/role/permission','Admin\UserController@roles_permissions');
Route::post('/assign/role/permission','Admin\UserController@assignRole')
    ->name('assign.role.permission');
Route::post('/update/role/permission/{id}','Admin\UserController@updateAssignRole')
    ->name('update.role.permission');
Route::get('/render/users/datatable','Admin\UserController@renderDataTable');

/* Master Admin Routes */
Route::group(['middleware'=>'role:master-admin'],function (){

    Route::get('/admin/user/list','Admin\UserController@index')
        ->middleware('permission:view');
    Route::get('/admin/user/create','Admin\UserController@create')
        ->middleware('permission:add');
    Route::post('/admin/user/create','Admin\UserController@store')
        ->name('store.user')
        ->middleware('permission:add');
    Route::get('/admin/user/edit','Admin\UserController@edit')
        ->middleware('permission:edit');

});

Route::get('render/question/user/datatable','Admin\DataController@renderUserDataTable');
Route::get('/all/front/users','Admin\DataController@users');
Route::get('/view/user/{id}','Admin\DataController@view');
Route::get('/delete/user/{id}','Admin\DataController@delete');

Route::post('/delete/all/users','Admin\DataController@deleteAll');
Route::post('/activate/all/users','Admin\DataController@activateAll');
Route::post('/deactivate/all/users','Admin\DataController@deactivateAll');

Route::get('/pending/question','Admin\QuestionController@pending');
Route::get('/view/pending/question/{id}','Admin\QuestionController@viewPending')
->name('view.pending');
Route::get('/approve/question/{id}','Admin\QuestionController@approveQuestion');
Route::get('/all/approved/questions','Admin\QuestionController@allApprovedQuestions');
Route::get('/render/approved/quest/datatable','Admin\QuestionController@renderApprovedDataTable');
Route::get('/view/approved/question/{id}','Admin\QuestionController@viewApproved')
    ->name('view.approved.question');
Route::get('/delete/quest/{id}','Admin\QuestionController@deleteQuestion')
    ->name('delete.quest');

/* Trash Items */
Route::get('/admin/trash-board','Admin\TrashController@trashBoard');
Route::get('/all/trashed/questions','Admin\TrashController@allTrashedQuestions');
Route::get('/restore/trashed/questions/{id}','Admin\TrashController@restoreTrashedQuestions');
Route::post('/permanently/delete/questions','Admin\TrashController@permanentlyDelete');
