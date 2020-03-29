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
Route::get('/favorites', 'FavoriteController@show');

Auth::routes();


Route::get('/auth', 'HomeController@auth')->name('auth');
Route::get('/account', 'HomeController@account')->middleware('auth');
Route::get('account/tracking/{order_id}', 'HomeController@tracking')->middleware('auth');
Route::get('/profile', 'HomeController@showProfile')->middleware('auth');
Route::put('/profile/update/{id}', 'HomeController@updateProfile')->middleware('auth');
Route::get('/history', 'HomeController@history')->middleware('auth');
Route::delete('/order/delete/{id}', 'HomeController@deleteOrder')->middleware('auth');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/sms', 'OrderController@sendSms');
Route::get('/checkSms', 'OrderController@checkSms');
Route::get('/confirmOrder', 'OrderController@confirmOrder');

Route::get('/pay', 'SberbankController@index');