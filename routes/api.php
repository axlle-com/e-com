<?php

use Application\v1\Controllers\AuthController as AppV1Auth;
use Application\v1\Controllers\WalletController as AppV1Wallet;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api'], static function () {
    # Приложение
    Route::group(['namespace' => 'App', 'prefix' => 'app'], static function () {
        Route::group(['namespace' => 'v1', 'prefix' => 'v1'], static function () {
            Route::post('login', [AppV1Auth::class, 'login']);
            Route::post('registration', [AppV1Auth::class, 'registration']);
            Route::group(['middleware' => 'app'], static function () {
                Route::post('test', [AppV1Auth::class, 'test']);
                Route::post('set-wallet', [AppV1Wallet::class, 'setWallet']);
                Route::post('get-wallet', [AppV1Wallet::class, 'getWallet']);
                Route::post('get-transaction', [AppV1Wallet::class, 'getTransaction']);
                Route::post('set-transaction', [AppV1Wallet::class, 'setTransaction']);
            });
        });
    });
});
