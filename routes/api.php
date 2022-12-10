<?php

use Application\v1\Controllers\AuthController as AppV1Auth;
use Application\v1\Controllers\WalletController as AppV1Wallet;
use Illuminate\Support\Facades\Route;
use Rest\Backend\v1\Controllers\WebHookController;

Route::group(['namespace' => 'Api'], static function () {
    # start Приложение
    Route::group(['namespace' => 'App', 'prefix' => 'app'], static function () {
        Route::group(['namespace' => 'v1', 'prefix' => 'v1'], static function () {
            Route::post('login', [AppV1Auth::class, 'login']);
            Route::post('registration', [AppV1Auth::class, 'registration']);
            Route::group(['middleware' => ['app', 'rate']], static function () {
                Route::post('test', [AppV1Auth::class, 'test']);
                Route::post('set-wallet', [AppV1Wallet::class, 'setWallet']);
                Route::post('get-wallet', [AppV1Wallet::class, 'getWallet']);
                Route::post('get-transaction', [AppV1Wallet::class, 'getTransaction']);
                Route::post('set-transaction', [AppV1Wallet::class, 'setTransaction']);
            });
        });
    });
    # end Приложение
    # start SPA
    Route::group(['namespace' => 'App', 'prefix' => 'rest'], static function () {
        Route::group(['namespace' => 'v1', 'prefix' => 'v1'], static function () {
        });
    });
    # end SPA
    # start webhook
    Route::group(['namespace' => 'App', 'prefix' => 'webhook'], static function () {
        Route::group(['namespace' => 'v1', 'prefix' => 'v1'], static function () {
            Route::any('telegram', [WebHookController::class, 'telegram']);
        });
    });
    # end webhook
});
