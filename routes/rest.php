<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App', 'prefix' => 'rest'], static function () {
    Route::group(['namespace' => 'v1', 'prefix' => 'v1'], static function () {
    });
});
