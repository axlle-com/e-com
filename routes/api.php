<?php

use Illuminate\Support\Facades\Route;
use Rest\Backend\v1\Controllers\WebHookController;

Route::group(['namespace' => 'Api'], static function () {
    # Приложение
    require_once 'app.php';
    # start SPA
    require_once 'rest.php';
    # start webhook
    Route::group(['namespace' => 'App', 'prefix' => 'webhook'], static function () {
        Route::group(['namespace' => 'v1', 'prefix' => 'v1'], static function () {
            Route::any('telegram', [WebHookController::class, 'telegram']);
        });
    });
});
