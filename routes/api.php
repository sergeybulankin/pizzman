<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('selected-categories', 'CategoryController@index');

Route::post('post-cart-in-delivery', 'OrderController@storeCartInOrder');

Route::get('selected-all-products', 'FoodController@index');
Route::get('selected-all-products-for-users', 'FoodController@cartForUser');
Route::get('catalog-products', 'FoodController@catalog');
Route::post('selection-by-category', 'FoodController@selectByCategory');
Route::post('selected-products-in-cart', 'FoodController@informationProductInCart');
Route::post('add-to-database-from-cart', 'FoodController@storeFromLocalStorage');
Route::post('delete-product-from-cart', 'FoodController@deleteFromCart');


Route::post('insert-call-me-number', 'CallController@store');

Route::post('add-to-favorite', 'FavoriteController@store');
Route::post('delete-of-favorite', 'FavoriteController@delete');
Route::post('select-all-favorite', 'FavoriteController@index');
Route::post('select-all-favorite-for-users', 'FavoriteController@favoriteForUser');
Route::get('count-favorites', 'FavoriteController@count');

Route::get('hit-sales', 'HitController@index');

Route::get('send-sms', 'OrderController@sendSms');
Route::post('check-sms', 'OrderController@checkSmsForRegistration');