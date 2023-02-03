<?php

use Illuminate\Support\Facades\Route;
use Web\Frontend\Controllers\CatalogAjaxController as FrontCatalogAjax;
use Web\Frontend\Controllers\CatalogController as FrontCatalog;
use Web\Frontend\Controllers\DeliveryAjaxController;
use Web\Frontend\Controllers\UserAjaxController as FrontUserAjax;

Route::group(['prefix' => 'catalog'], static function () {
    Route::get('/', [FrontCatalog::class, 'index']);
    Route::get('/{alias}', [FrontCatalog::class, 'route']);
    Route::group(['prefix' => 'user'], static function () {
        Route::get('/order', [FrontCatalog::class, 'order']);
        Route::get('/order-pay', [FrontCatalog::class, 'orderPay']);
        Route::get('/invoice-pay', [FrontCatalog::class, 'invoicePay']);
        Route::group(['middleware' => 'register'], static function () {
            Route::get('/order-confirm', [FrontCatalog::class, 'orderConfirm']);
            Route::get('/order-pay-confirm', [FrontCatalog::class, 'orderPayConfirm']);
        });
        Route::group(['prefix' => 'ajax', 'middleware' => 'cookie'], static function () {
            Route::post('/login', [FrontUserAjax::class, 'login']);
            Route::post('/registration', [FrontUserAjax::class, 'registration']);
            Route::post('/restore-password', [FrontUserAjax::class, 'restorePassword']);
            Route::post('/change-password', [FrontUserAjax::class, 'changePassword']);
        });
    });
    Route::group(['prefix' => 'ajax', 'middleware' => 'cookie'], static function () {
        Route::post('/basket-add', [FrontCatalogAjax::class, 'basketAdd']);
        Route::post('/basket-delete', [FrontCatalogAjax::class, 'basketDelete']);
        Route::post('/basket-clear', [FrontCatalogAjax::class, 'basketClear']);
        Route::post('/basket-change', [FrontCatalogAjax::class, 'basketChange']);
        Route::post('/order-save', [FrontCatalogAjax::class, 'orderSave']);
        Route::post('/order-pay', [FrontCatalogAjax::class, 'orderPay']);
        Route::post('/get-city', [DeliveryAjaxController::class, 'city']);
        Route::post('/get-object', [DeliveryAjaxController::class, 'getObject']);
        Route::post('/get-delivery-info', [DeliveryAjaxController::class, 'getDeliveryInfo']);
        Route::post('/get-address-courier', [DeliveryAjaxController::class, 'getAddressCourier']);
    });
});