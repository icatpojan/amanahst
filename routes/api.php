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
Route::get('redirect/{driver}', 'UserController@redirectToProvider');
// buat ngehandle redirect ke platform yang di tuju
Route::get('{driver}/callback', 'UserController@handleProviderCallback');
//mengambil email, id dan foto dari akun google
// Route::resource('product', 'ProductController')->middleware('jwt.verify');

// ini buat public
Route::get('product', 'ProductController@index');
// ini buat ngambil semua
Route::get('kategori/{product}', 'ProductController@kategori');
//ini buat ambil data berdasar kategori
Route::get('product/{product} ', 'ProductController@show');
//ambil 1 data berdasarkan id
Route::post('product/search', 'ProductController@search');
//nyari berdasarkan nama
Route::get('category', 'ProductController@category');
//ngambil category
// ini buat customer
Route::get('user', 'UserController@indexes');


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
Route::post('konfirmasi-check-out', 'OrderController@konfirmasi')->middleware('jwt.verify');
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
//ini buat bayar

Route::get('gasorder', 'PaymentController@gasOrder')->middleware('jwt.verify');
//ini buat ngambil data orderan yang ngorder barang kita
Route::get('payment/{id}', 'PaymentController@show')->middleware('jwt.verify');
//ini buat ngambil bukti pembayaran berdasarkan id order
Route::patch('send/{id}', 'PaymentController@send')->middleware('jwt.verify');
//buat konfirmasi penjual kalo barang udah di kirim
Route::get('klien', 'HistoryController@klien')->middleware('jwt.verify');
//ini buat ngambil data orderan yang ngorder barang kita
Route::post('accept/{id}', 'HistoryController@accept')->middleware('jwt.verify');
//ini buat pembeli kalo udah nerima barang



// message
Route::get('/allmessage', 'MessageController@index')->name('home')->middleware('jwt.verify');
//ambil semua pesan
Route::get('/message/{id}', 'MessageController@getMessage')->name('message')->middleware('jwt.verify');
// buat nge get pesan
Route::post('message', 'MessageController@sendMessage')->middleware('jwt.verify');
// buat ngirim pesan
