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
// ini buat ngambil semua
Route::get('product/{product} ', 'ProductController@show');
//ambil 1 data berdasarkan id
Route::post('product/search', 'ProductController@search');
//nyari berdasarkan nama


// ini buat customer
Route::post('product', 'ProductController@store')->middleware('jwt.verify');
//tambah produk
Route::put('product/{product} ', 'ProductController@update')->middleware('jwt.verify');
//update produk
Route::delete('product/{product} ', 'ProductController@destroy')->middleware('jwt.verify');
//hapus produk