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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('news/create','Admin\NewsController@add');
    Route::post('news/create','Admin\NewsController@create');//postデータの追加に使用
    Route::get('news', 'Admin\NewsController@index');
    Route::get('news/edit', 'Admin\NewsController@edit');
    Route::post('news/edit', 'Admin\NewsController@update'); //url最後に/?id=idの番号を入力する
    Route::get('news/delete','Admin\NewsController@delete');

});

//課題3
// Route::get('XXX','AAAController@bbb');

//課題4
Route::group(['prefix' => 'admin','middleware' => 'auth'],function(){
    Route::get('profile/create','Admin\ProfileController@add');
    Route::post('profile/create','Admin\ProfileController@create');
    Route::get('profile/edit','Admin\ProfileController@edit');
    Route::post('profile/edit','Admin\ProfileController@update');
    Route::get('profile', 'Admin\ProfileController@index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
