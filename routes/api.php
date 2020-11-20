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
Route::get('category', 'ProductController@category');
//ngambil category
// ini buat customer


//ini buat penjual
Route::get('ambilah', 'ProductController@ambilah')->middleware('jwt.verify');
//ini buat ngambil barang yang dia jual
Route::post('product', 'ProductController@store')->middleware('jwt.verify');
//tambah produk
Route::put('product/{product} ', 'ProductController@update')->middleware('jwt.verify');
//update produk
Route::delete('product/{product} ', 'ProductController@destroy')->middleware('jwt.verify');
//hapus produk


//ini buat pembeli
Route::get('order/{id}', 'OrderController@index')->middleware('jwt.verify');
//ini masuk kehalaman detail produk cuman didalemnya ada frm input jumlah pesanan
Route::post('order/{id}', 'OrderController@order')->middleware('jwt.verify');
//ini buat nambah ke keranjang
Route::get('check-out', 'OrderController@check_out')->middleware('jwt.verify');
//ini buat ngeliat isi keranjang
Route::delete('check-out/{id}', 'OrderController@delete')->middleware('jwt.verify');
//ngehapus isi keranjang satu barang doang menurut order
Route::get('konfirmasi-check-out', 'OrderController@konfirmasi')->middleware('jwt.verify');
//konfirmasi pembelian,keluar dari keranjang ke halaman datail

Route::get('profile', 'ProfileController@index')->middleware('jwt.verify');
//menampilkan profil user yang sedang login
Route::post('profile', 'ProfileController@update')->middleware('jwt.verify');
//mengupdate profile

Route::get('history', 'HistoryController@index')->middleware('jwt.verify');
//ngeliat pesanan
Route::get('history/{id}', 'HistoryController@detail')->middleware('jwt.verify');
//ngliat detail pesanan


Route::get('payment', 'PaymentController@paymentForm')->middleware('jwt.verify');
//ini masuk kehalaman detail produk cuman didalemnya ada frm input jumlah pesanan
Route::post('payment', 'PaymentController@storePayment')->middleware('jwt.verify');
//ini buat nambah ke keranjang