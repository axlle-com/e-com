<?php

use Illuminate\Support\Facades\Route;
use Web\Backend\Controllers\BlogAjaxController as BackBlogAjax;
use Web\Backend\Controllers\BlogController as BackBlog;
use Web\Backend\Controllers\CatalogAjaxController as BackCatalogAjax;
use Web\Backend\Controllers\CatalogController as BackCatalog;
use Web\Backend\Controllers\CurrencyAjaxController as BackPCurrencyAjax;
use Web\Backend\Controllers\DashboardController;
use Web\Backend\Controllers\DocumentAjaxController as BackDocumentAjax;
use Web\Backend\Controllers\DocumentController as BackDocument;
use Web\Backend\Controllers\ImageAjaxController as BackImageAjax;
use Web\Backend\Controllers\PageAjaxController as BackPageAjax;
use Web\Backend\Controllers\PageController as BackPage;
use Web\Backend\Controllers\UserController as BackUser;
use Web\Backend\Controllers\WidgetAjaxController as BackWidgetAjax;
use Web\Frontend\Controllers\AuthController as FrontAuth;
use Web\Frontend\Controllers\CatalogAjaxController as FrontCatalogAjax;
use Web\Frontend\Controllers\CatalogController as FrontCatalog;
use Web\Frontend\Controllers\SiteController as FrontSite;
use Web\Frontend\Controllers\UserAjaxController as FrontUserAjax;
use Web\Frontend\Controllers\UserController as FrontUser;

#start Backend
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], static function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'page'], static function () {
        Route::get('/', [BackPage::class, 'indexPage']);
        Route::get('/update/{id?}', [BackPage::class, 'updatePage']);
        Route::get('/delete/{id?}', [BackPage::class, 'deletePage']);
        Route::post('/ajax-save', [BackPageAjax::class, 'updatePage']);
    });
    Route::group(['prefix' => 'user'], static function () {
        Route::get('/profile', [BackUser::class, 'profile']);
        Route::group(['namespace' => 'Ajax', 'prefix' => 'ajax'], static function () {
        });
    });
    Route::group(['prefix' => 'blog'], static function () {
        Route::get('/category', [BackBlog::class, 'indexCategory']);
        Route::get('/category-update/{id?}', [BackBlog::class, 'updateCategory']);
        Route::get('/category-delete/{id?}', [BackBlog::class, 'deleteCategory']);
        Route::get('/post', [BackBlog::class, 'indexPost']);
        Route::get('/post-update/{id?}', [BackBlog::class, 'updatePost']);
        Route::get('/post-delete/{id?}', [BackBlog::class, 'deletePost']);
        Route::group(['prefix' => 'ajax'], static function () {
            Route::post('/save-category', [BackBlogAjax::class, 'saveCategory']);
            Route::post('/save-post', [BackBlogAjax::class, 'savePost']);
            Route::post('/delete-image', [BackImageAjax::class, 'deleteImage']);
            Route::post('/delete-widget', [BackWidgetAjax::class, 'deleteWidget']);
        });
    });
    Route::group(['prefix' => 'catalog'], static function () {
        Route::get('/category', [BackCatalog::class, 'indexCategory']);
        Route::get('/category-update/{id?}', [BackCatalog::class, 'updateCategory']);
        Route::get('/category-delete/{id?}', [BackCatalog::class, 'deleteCategory']);
        Route::get('/product', [BackCatalog::class, 'indexCatalogProduct']);
        Route::get('/product-update/{id?}', [BackCatalog::class, 'updateCatalogProduct']);
        Route::get('/product-delete/{id?}', [BackCatalog::class, 'deleteCatalogProduct']);
        Route::get('/coupon', [BackCatalog::class, 'indexCoupon']);
        Route::group(['prefix' => 'document'], static function () {
            Route::get('/', [BackDocument::class, 'indexDocument']);
            Route::get('/update/{id?}', [BackDocument::class, 'updateDocument']);
            Route::get('/print/{id}', [BackDocument::class, 'indexDocument']);
            Route::get('/delete/{id}', [BackDocument::class, 'indexDocument']);
        });
        Route::group(['prefix' => 'ajax'], static function () {
            Route::post('/save-category', [BackCatalogAjax::class, 'saveCategory']);
            Route::post('/save-product', [BackCatalogAjax::class, 'saveProduct']);
            Route::post('/save-product-sort', [BackCatalogAjax::class, 'saveSortProduct']);
            Route::post('/delete-image', [BackCatalogAjax::class, 'deleteImage']);
            Route::post('/add-property', [BackCatalogAjax::class, 'addProperty']);
            Route::post('/add-property-self', [BackCatalogAjax::class, 'addPropertySelf']);
            Route::post('/add-coupon', [BackCatalogAjax::class, 'addCoupon']);
            Route::post('/delete-coupon', [BackCatalogAjax::class, 'deleteCoupon']);
            Route::post('/gift-coupon', [BackCatalogAjax::class, 'giftCoupon']);
            Route::post('/save-property-self', [BackCatalogAjax::class, 'savePropertySelf']);
            Route::post('/delete-property', [BackCatalogAjax::class, 'deleteProperty']);
            Route::post('/show-rate-currency', [BackPCurrencyAjax::class, 'showRateCurrency']);
            Route::post('/get-product', [BackDocumentAjax::class, 'getProduct']);
            Route::post('/save-document', [BackDocumentAjax::class, 'saveDocument']);
            Route::post('/posting-document', [BackDocumentAjax::class, 'postingDocument']);
            Route::post('/delete-document', [BackDocumentAjax::class, 'deleteDocument']);
            Route::post('/delete-document-content', [BackDocumentAjax::class, 'deleteDocumentContent']);
        });
    });
});
#end Backend
#start Frontend
Route::get('/', [FrontSite::class, 'index'])->name('home');
Route::group(['prefix' => 'user'], static function () {
    Route::get('/order', [FrontCatalog::class, 'order']);
    Route::get('/verification-token', [FrontUser::class, 'activateToken']);
    Route::post('/activate-phone', [FrontUserAjax::class, 'activatePhone']);
    Route::post('/activate-phone-code', [FrontUserAjax::class, 'activatePhoneCode']);
    Route::group(['middleware' => 'register'], static function () {
        Route::get('/profile', [FrontUser::class, 'profile']);
        Route::get('/activate', [FrontUser::class, 'activate']);
        Route::get('/logout', [FrontAuth::class, 'logout']);
        Route::get('/order-pay', [FrontCatalog::class, 'orderPay']);
    });
    Route::group(['prefix' => 'ajax', 'middleware' => 'cookie'], static function () {
        Route::post('/login', [FrontUserAjax::class, 'login']);
        Route::post('/registration', [FrontUserAjax::class, 'registration']);
    });
});
Route::group(['prefix' => 'catalog'], static function () {
    Route::get('/', [FrontCatalog::class, 'index']);
    Route::get('/{alias}', [FrontCatalog::class, 'route']);
    Route::group(['prefix' => 'ajax', 'middleware' => 'cookie'], static function () {
        Route::post('/basket-add', [FrontCatalogAjax::class, 'basketAdd']);
        Route::post('/basket-delete', [FrontCatalogAjax::class, 'basketDelete']);
        Route::post('/basket-clear', [FrontCatalogAjax::class, 'basketClear']);
        Route::post('/basket-change', [FrontCatalogAjax::class, 'basketChange']);
        Route::post('/order-save', [FrontCatalogAjax::class, 'orderSave']);
    });
});
Route::get('/{alias}', [FrontSite::class, 'route']);
#end Frontend
