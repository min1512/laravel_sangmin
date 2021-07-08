<?php

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\API as UserResource;
use App\Models\Users;
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
Route::get('/login1', 'LoginController@check')->name("login");
Route::get('/login/{id?}', 'LoginController@write');
Route::Post('/login/{id?}', 'LoginController@save');
Route::post('/success','Successcontroller@index');
Route::post('/search','Successcontroller@search');
Route::get('/api/user/{id}', 'LoginController@api');
Route::POST('/login_test','LoginController@login_test');
Route::get('/date/{month?}', 'LoginController@date')->name('date');
Route::get('/date_check','LoginController@date_check');

Route::group(['middleware' => 'lsm.loginCheck'], function() {
    Route::get('/api/Naver_API','LoginController@Naver_API');
	Route::get('/success','Successcontroller@index2')->name('success');
	Route::any('/','LoginController@index')->name('main');
	Route::get('/list','LoginController@list');
	Route::get('/logout','Successcontroller@logout');
	Route::get('/delete/{id?}', 'DeleteController@index');
    Route::get('/write/{id?}','Successcontroller@write');
    Route::post('/write/{id?}','Successcontroller@save');
    Route::get('/delete/{id?}','Successcontroller@delete');
});
