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

Route::get('selected-all-products', 'ProductController@index');
Route::post('selection-by-category', 'ProductController@selectByCategory');
Route::post('selected-products-in-cart', 'ProductController@informationProductInCart');

Route::post('insert-call-me-number', 'CallController@store');