<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('webpay/plus')->group(function () {
        Route::get('redirect', 'Twgroup\WebPay\Http\Controllers\BagistoWebPayController@redirect')->name('webpay_plus.redirect');

        Route::get('redirect/mall', 'Twgroup\WebPay\Http\Controllers\BagistoWebPayMallController@redirect')->name('webpay_plus_mall.redirect');


        Route::get('/cancel', 'Twgroup\WebPay\Http\Controllers\BagistoWebPayController@cancel')->name('webpay_plus.cancel');
        Route::get('/cancel/mall', 'Twgroup\WebPay\Http\Controllers\BagistoWebPayMallController@cancel')->name('webpay_plus_mall.cancel');
    });
});

Route::post('webpay/plus/success', 'Twgroup\WebPay\Http\Controllers\BagistoWebPayController@success')->name('webpay_plus.success');
Route::post('webpay/plus/ipn', 'Twgroup\WebPay\Http\Controllers\BagistoWebPayController@ipn')->name('webpay_plus.ipn');

Route::post('webpay/mall/success', 'Twgroup\WebPay\Http\Controllers\BagistoWebPayMallController@success')->name('webpay_plus_mall.success');
Route::post('webpay/mall/ipn', 'Twgroup\WebPay\Http\Controllers\BagistoWebPayMallController@ipn')->name('webpay_plus_mall.ipn');
