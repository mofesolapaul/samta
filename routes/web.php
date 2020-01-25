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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'account', 'as' => 'account.'], function() {
    Route::get('{account}', 'AccountController@show')->name('show');
    Route::get('create', 'AccountController@create')->name('create');
    Route::get('{account}/send', 'AccountController@sendMoney')->name('send');
    Route::post('{account}/transfer', 'AccountController@transfer')->name('transfer');
});