<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
// ini buat autotikasi super admin gak pake

// Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('document', 'DoctController@index');

Route::group(['prefix' => 'administrator', 'middleware' => 'auth'], function() {
    Route::get('register', 'Auth\DaftarController@index');
    Route::post('register', 'Auth\DaftarController@register')->name('register');
    Route::get('/home', 'HomeController@index')->name('home');     
    Route::get('adminis', 'HomeController@dash')->name('dash');
    Route::resource('category', 'CategoryController')->except(['create', 'show']);
    Route::resource('produk', 'ProdukController');
    Route::resource('transaksi', 'TransaksiController');
    Route::resource('pembeli', 'PembeliController');
    Route::get('pendapatan/{id}', 'PembeliController@pendapatan')->name('pendapatan');
    Route::get('trash', 'PembeliController@trash')->name('trash');
    Route::get('trash/{id}', 'PembeliController@restore')->name('restore');
    Route::get('permanen/{id}', 'PembeliController@hapus_permanen')->name('permanen');    
});
Route::get('/', 'Web\FrontController@index')->name('home');
Route::get('prodak/{id}', 'Web\ProdakController@show')->name('prodak');
Route::get('loginmember', 'Web\LoginMemberController@login')->name('loginmember');
Route::get('persaingan', 'PembeliController@persaingan');
