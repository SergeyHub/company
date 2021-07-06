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
Route::get('foreign/payment/yandex', 'CheckoutController@yandex');

Route::get('foreign/payment/btc', 'CheckoutController@btc');

Route::get('foreign', function () { return ' 123'; });
