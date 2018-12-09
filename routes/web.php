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



Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Route::get('/', function () {
    //     return view('welcome');
    // });
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/prepaid-balance', 'CheckoutController@prepaidbalance')->name('prepaidbalance');
    Route::post('/prepaid-balance', 'CheckoutController@checkout_prepaidbalance')->name('checkoutprepaidbalance');
    Route::get('/product', 'CheckoutController@product')->name('product');
    Route::post('/product', 'CheckoutController@checkout_product')->name('checkoutproduct');
    Route::get('/success', 'CheckoutController@checkout_success')->name('checkoutsuccess');
    Route::get('/payment', 'CheckoutController@payment')->name('checkoutpayment');
    Route::post('/payment', 'CheckoutController@do_payment')->name('checkoutdopayment');
    Route::get('/order', 'CheckoutController@order')->name('order');
});

Route::get('/orderexpired', 'CheckoutController@orderexpired')->name('orderexpired');