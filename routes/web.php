<?php

use App\Common\Modules\Web\Backend\Controllers\BlogController as BackBlog;
use App\Common\Modules\Web\Backend\Controllers\BlogAjaxController as BackBlogAjax;
use App\Common\Modules\Web\Backend\Controllers\DashboardController;
use App\Common\Modules\Web\Backend\Controllers\UserController as BackUser;
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
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/profile', [BackUser::class,'profile']);
    Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], static function () {
        Route::get('/category', [BackBlog::class,'indexCategory']);
        Route::get('/category-update/{id?}', [BackBlog::class,'updateCategory']);
        Route::get('/post', [BackBlog::class,'indexPost']);
        Route::get('/post-update/{id?}', [BackBlog::class,'updatePost']);
        Route::group(['namespace' => 'Ajax', 'prefix' => 'ajax'], static function () {
            Route::post('/save-category', [BackBlogAjax::class,'saveCategory']);
        });
    });
});
