<?php

use App\Common\Modules\Web\Backend\Controllers\BlogAjaxController as BackBlogAjax;
use App\Common\Modules\Web\Backend\Controllers\BlogController as BackBlog;
use App\Common\Modules\Web\Backend\Controllers\CatalogAjaxController as BackCatalogAjax;
use App\Common\Modules\Web\Backend\Controllers\CatalogController as BackCatalog;
use App\Common\Modules\Web\Backend\Controllers\DashboardController;
use App\Common\Modules\Web\Backend\Controllers\ImageAjaxController as BackImageAjax;
use App\Common\Modules\Web\Backend\Controllers\PageAjaxController as BackPageAjax;
use Web\Backend\Controllers\CurrencyAjaxController as BackPCurrencyAjax;
use App\Common\Modules\Web\Backend\Controllers\PageController as BackPage;
use App\Common\Modules\Web\Backend\Controllers\UserController as BackUser;
use App\Common\Modules\Web\Backend\Controllers\WidgetAjaxController as BackWidgetAjax;
use App\Common\Modules\Web\Frontend\Controllers\CatalogController as FrontCatalog;
use Illuminate\Support\Facades\Route;
use Web\Frontend\Controllers\AuthController as FrontAuth;
use Web\Frontend\Controllers\SiteController as FrontSite;

#start Backend
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin'], static function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [BackUser::class, 'profile']);
    Route::group(['namespace' => 'page', 'prefix' => 'page'], static function () {
        Route::get('/', [BackPage::class, 'indexPage']);
        Route::get('/update/{id?}', [BackPage::class, 'updatePage']);
        Route::get('/delete/{id?}', [BackPage::class, 'deletePage']);
        Route::post('/ajax-save', [BackPageAjax::class, 'updatePage']);
    });
    Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], static function () {
        Route::get('/category', [BackBlog::class, 'indexCategory']);
        Route::get('/category-update/{id?}', [BackBlog::class, 'updateCategory']);
        Route::get('/category-delete/{id?}', [BackBlog::class, 'deleteCategory']);
        Route::get('/post', [BackBlog::class, 'indexPost']);
        Route::get('/post-update/{id?}', [BackBlog::class, 'updatePost']);
        Route::get('/post-delete/{id?}', [BackBlog::class, 'deletePost']);
        Route::group(['namespace' => 'Ajax', 'prefix' => 'ajax'], static function () {
            Route::post('/save-category', [BackBlogAjax::class, 'saveCategory']);
            Route::post('/save-post', [BackBlogAjax::class, 'savePost']);
            Route::post('/delete-image', [BackImageAjax::class, 'deleteImage']);
            Route::post('/delete-widget', [BackWidgetAjax::class, 'deleteWidget']);
        });
    });
    Route::group(['namespace' => 'catalog', 'prefix' => 'catalog'], static function () {
        Route::get('/category', [BackCatalog::class, 'indexCategory']);
        Route::get('/category-update/{id?}', [BackCatalog::class, 'updateCategory']);
        Route::get('/category-delete/{id?}', [BackCatalog::class, 'deleteCategory']);
        Route::get('/product', [BackCatalog::class, 'indexCatalogProduct']);
        Route::get('/product-update/{id?}', [BackCatalog::class, 'updateCatalogProduct']);
        Route::get('/product-delete/{id?}', [BackCatalog::class, 'deleteCatalogProduct']);
        Route::group(['namespace' => 'Ajax', 'prefix' => 'ajax'], static function () {
            Route::post('/save-category', [BackCatalogAjax::class, 'saveCategory']);
            Route::post('/save-product', [BackCatalogAjax::class, 'saveProduct']);
            Route::post('/delete-image', [BackCatalogAjax::class, 'deleteImage']);
            Route::post('/show-rate-currency', [BackPCurrencyAjax::class, 'showRateCurrency']);
        });
    });
});
#end Backend

#start Frontend
Route::get('/', [FrontSite::class, 'index'])->name('home');
Route::group(['namespace' => 'Catalog', 'prefix' => 'catalog'], static function () {
    Route::get('/', [FrontCatalog::class, 'index']);
    Route::get('/{alias}', [FrontCatalog::class, 'route']);
});
Route::group(['middleware' => 'guest'], static function () {
    Route::get('/register', [FrontAuth::class, 'registerForm'])->name('register.form');
    Route::post('/register', [FrontAuth::class, 'register'])->name('register');
    Route::any('/login', [FrontAuth::class, 'login'])->name('login');
});
Route::get('/{alias}', [FrontSite::class, 'route']);
#end Frontend
