<?php

use Illuminate\Support\Facades\Route;
use Web\Frontend\Controllers\AuthController as FrontAuth;
use Web\Frontend\Controllers\SiteController as FrontSite;

Route::get('/', [FrontSite::class, 'index'])->name('home');
Route::group(['middleware' => 'guest'], static function () {
    Route::get('/register', [FrontAuth::class, 'registerForm'])->name('register.form');
    Route::post('/register', [FrontAuth::class, 'register'])->name('register');
    Route::any('/login', [FrontAuth::class, 'login'])->name('login');
});
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], static function () {

});
