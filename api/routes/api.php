<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/my/items', 'my\ItemController@index')->name('my_items');
    Route::get('/my/items/{id}', 'my\ItemController@show')->name('my_item');
    Route::post('/my/items/{id}', 'my\ItemController@update')->name('my_item');
    Route::delete('/my/items/{id}', 'my\ItemController@destroy')->name('my_item');
    Route::post('/my/items', 'my\ItemController@store')->name('my_items');
    Route::get('/my/user', 'my\UserController@show')->name('my_user');
    Route::post('/my/user', 'my\UserController@update')->name('my_user');
    Route::get('/my/notifications', 'my\NotificationController@index')->name('my_notifications');
    Route::post('/my/reviews', 'my\ReviewController@store')->name('my_reviews');
    Route::get('/items/{item}/contacts', 'ItemController@contacts')->name('item_contacts');
    Route::post('/my/services', 'my\ServiceController@request')->name('my_services');
});

Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/{id}', 'CategoryController@show')->name('category');
Route::get('/items', 'ItemController@index')->name('items');
Route::get('/items/{id}', 'ItemController@show')->name('item');

Route::post('/auth/register', 'AuthController@register')->name('register');
Route::post('/auth/confirm', 'AuthController@confirm')->name('confirm');
Route::post('/auth/autologin', 'AuthController@autologin')->name('autologin');

Route::post('/telegram/webhook', 'TelegramController@webhook')->name('webhook');

Route::get('/cities', 'CityController@index')->name('cities');
