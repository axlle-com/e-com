<?php

use Illuminate\Support\Facades\Route;
use Web\Frontend\Controllers\AjaxController as FrontAjax;
use Web\Frontend\Controllers\AuthController as FrontAuth;
use Web\Frontend\Controllers\SiteController as FrontSite;
use Web\Frontend\Controllers\SPA\AjaxController as FrontTokyoAjax;
use Web\Frontend\Controllers\UserAjaxController as FrontUserAjax;
use Web\Frontend\Controllers\UserController as FrontUser;

Route::get('/', [FrontSite::class, 'index'])->name('home');

Route::group(['prefix' => 'user'], static function () {
    Route::get('/verification-token', [FrontUser::class, 'activateToken']);
    Route::get('/restore-password', [FrontUser::class, 'restorePassword']);
    Route::post('/activate-phone', [FrontUserAjax::class, 'activatePhone']);
    Route::post('/activate-phone-code', [FrontUserAjax::class, 'activatePhoneCode']);
    Route::get('/reset-password', [FrontUser::class, 'resetPassword']);
    Route::group(['middleware' => 'register'], static function () {
        Route::get('/profile', [FrontUser::class, 'profile']);
        Route::get('/activate', [FrontUser::class, 'activate']);
        Route::get('/logout', [FrontAuth::class, 'logout']);
    });
    Route::group(['prefix' => 'ajax', 'middleware' => 'cookie'], static function () {
        Route::post('/login', [FrontUserAjax::class, 'login']);
        Route::post('/registration', [FrontUserAjax::class, 'registration']);
        Route::post('/restore-password', [FrontUserAjax::class, 'restorePassword']);
        Route::post('/change-password', [FrontUserAjax::class, 'changePassword']);
    });
});

Route::group(['prefix' => 'ajax', 'middleware' => 'cookie'], static function () {
    Route::post('/add-comment', [FrontAjax::class, 'addComment']);
    Route::post('/open-comment', [FrontAjax::class, 'openComment']);
    Route::post('/contact', [FrontAjax::class, 'contact']);
    Route::group(['prefix' => 'tokyo'], static function () {
        Route::post('/route', [FrontTokyoAjax::class, 'route', 'alias' => null]);
    });
});

if(config('app.catalog')) {
    require_once 'catalog.php'; # /catalog
}

Route::get('/{alias}', [FrontSite::class, 'route']);
