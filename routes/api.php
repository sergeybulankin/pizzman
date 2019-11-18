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

Route::post('post-cart-in-delivery', 'DeliveryController@storeCartInOrder');

Route::get('selected-all-products', 'FoodController@index');
Route::get('selected-all-products-for-users', 'FoodController@cartForUser');
Route::get('catalog-products', 'FoodController@catalog');
Route::post('selection-by-category', 'FoodController@selectByCategory');
Route::post('selected-products-in-cart', 'FoodController@informationProductInCart');
Route::post('add-to-database-from-cart', 'FoodController@storeFromLocalStorage');

Route::post('insert-call-me-number', 'CallController@store');

Route::post('add-to-favorite', 'FavoriteController@store');
Route::post('delete-of-favorite', 'FavoriteController@delete');
Route::get('select-all-favorite', 'FavoriteController@index');
Route::get('count-favorites', 'FavoriteController@count');