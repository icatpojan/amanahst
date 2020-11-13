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
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

// Route::resource('product', 'ProductController')->middleware('jwt.verify');
// ini buat public
Route::get('product', 'ProductController@index');
Route::get('product/{product} ', 'ProductController@show');
Route::post('product/search', 'ProductController@search');

// ini buat customer
Route::post('product', 'ProductController@store')->middleware('jwt.verify');
Route::put('product/{product} ', 'ProductController@update')->middleware('jwt.verify');
Route::delete('product/{product} ', 'ProductController@destroy')->middleware('jwt.verify');