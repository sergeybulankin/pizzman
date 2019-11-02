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

Route::get('/', 'HomeController@show');
Route::get('/cart', 'CartController@show');
Route::get('/delivery/{u_id}', 'DeliveryController@show');

Route::post('/treatment', 'OrderController@treatment');

Auth::routes();


Route::get('/auth', 'HomeController@auth')->name('auth');
Route::get('/account', 'HomeController@account')->middleware('auth');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');