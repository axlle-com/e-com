<?php

use App\Common\Modules\Web\Backend\Controllers\BlogCommentController;
use Illuminate\Support\Facades\Route;
use Web\Backend\Controllers\BlogAjaxController;
use Web\Backend\Controllers\BlogController;
use Web\Backend\Controllers\CatalogAjaxController;
use Web\Backend\Controllers\CatalogController;
use Web\Backend\Controllers\CurrencyAjaxController;
use Web\Backend\Controllers\DashboardController;
use Web\Backend\Controllers\DocumentAjaxController;
use Web\Backend\Controllers\DocumentController;
use Web\Backend\Controllers\ImageAjaxController;
use Web\Backend\Controllers\PageAjaxController;
use Web\Backend\Controllers\PageController;
use Web\Backend\Controllers\StorageAjaxController;
use Web\Backend\Controllers\UserAjaxController;
use Web\Backend\Controllers\UserController;
use Web\Backend\Controllers\WidgetAjaxController;

Route::get('/login', [UserController::class, 'login'])->prefix('admin');
Route::post('/login', [UserController::class, 'auth'])->prefix('admin');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], static function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'page'], static function () {
        Route::get('/', [PageController::class, 'indexPage']);
        Route::get('/update/{id?}', [PageController::class, 'updatePage']);
        Route::get('/delete/{id?}', [PageController::class, 'deletePage']);
        Route::post('/ajax-save', [PageAjaxController::class, 'updatePage']);
    });
    Route::group(['prefix' => 'user'], static function () {
        Route::get('/profile', [UserController::class, 'profile']);
        Route::group(['namespace' => 'Ajax', 'prefix' => 'ajax'], static function () {
            Route::post('/save', [UserAjaxController::class, 'profile']);
        });
    });
    Route::group(['prefix' => 'blog'], static function () {
        Route::get('/category', [BlogController::class, 'indexCategory']);
        Route::get('/category-update/{id?}', [BlogController::class, 'updateCategory']);
        Route::get('/category-delete/{id?}', [BlogController::class, 'deleteCategory']);

        Route::get('/post', [BlogController::class, 'indexPost']);
        Route::post('/post', [BlogController::class, 'indexPostForm'])->name('Create');
        Route::get('/post-update/{id?}', [BlogController::class, 'updatePost']);
        Route::get('/post-delete/{id?}', [BlogController::class, 'deletePost'])->name('Delete');

        Route::get('/comment', [BlogCommentController::class, 'index']);
        Route::post('/comment', [BlogCommentController::class, 'update'])->name('Create');
        Route::get('/comment-update/{id?}', [BlogCommentController::class, 'update']);
        Route::get('/comment-delete/{id?}', [BlogCommentController::class, 'deletePost'])->name('Delete');

        Route::group(['prefix' => 'ajax'], static function () {
            Route::post('/save-category', [BlogAjaxController::class, 'saveCategory']);
            Route::post('/save-post', [BlogAjaxController::class, 'savePost'])->name('Create');
            Route::post('/delete-image', [ImageAjaxController::class, 'deleteImage']);
            Route::post('/delete-widget', [WidgetAjaxController::class, 'deleteWidget']);
        });
    });
    Route::group(['prefix' => 'catalog'], static function () {
        Route::get('/category', [CatalogController::class, 'indexCategory']);
        Route::get('/category-update/{id?}', [CatalogController::class, 'updateCategory']);
        Route::get('/category-delete/{id?}', [CatalogController::class, 'deleteCategory']);
        Route::get('/product', [CatalogController::class, 'indexCatalogProduct']);
        Route::get('/product-update/{id?}', [CatalogController::class, 'updateCatalogProduct']);
        Route::get('/product-delete/{id?}', [CatalogController::class, 'deleteCatalogProduct']);
        Route::get('/coupon', [CatalogController::class, 'indexCoupon']);
        Route::get('/storage', [CatalogController::class, 'indexStorage']);
        Route::get('/property', [CatalogController::class, 'indexProperty']);
        Route::get('/property-update/{id?}', [CatalogController::class, 'updateProperty']);
        Route::group(['prefix' => 'document'], static function () {
            Route::get('/order', [DocumentController::class, 'indexDocumentOrder']);
            Route::get('/order-update/{id?}', [DocumentController::class, 'updateDocumentOrder']);
            Route::get('/order-delete/{id?}', [DocumentController::class, 'updateDocumentOrder']);
            Route::get('/order-print/{id?}', [DocumentController::class, 'updateDocumentOrder']);

            Route::get('/fin-invoice', [DocumentController::class, 'indexDocumentFinInvoice']);

            Route::get('/coming', [DocumentController::class, 'indexDocumentComing']);
            Route::get('/coming-update/{id?}', [DocumentController::class, 'updateDocumentComing']);
            Route::get('/coming-delete/{id?}', [DocumentController::class, 'updateDocumentComing']);
            Route::get('/coming-print/{id?}', [DocumentController::class, 'updateDocumentComing']);

            Route::get('/reservation', [DocumentController::class, 'indexDocumentReservation']);
            Route::get('/reservation-update/{id?}', [DocumentController::class, 'updateDocumentReservation']);
            Route::get('/reservation-delete/{id?}', [DocumentController::class, 'updateDocumentReservation']);
            Route::get('/reservation-print/{id?}', [DocumentController::class, 'updateDocumentReservation']);

            Route::get('/reservation-cancel', [DocumentController::class, 'indexDocumentReservationCancel']);
            Route::get('/reservation-cancel-update/{id?}', [DocumentController::class, 'updateDocumentReservationCancel']);
            Route::get('/reservation-cancel-delete/{id?}', [DocumentController::class, 'updateDocumentReservationCancel']);
            Route::get('/reservation-cancel-print/{id?}', [DocumentController::class, 'updateDocumentReservationCancel']);

            Route::get('/sale', [DocumentController::class, 'indexDocumentSale']);
            Route::get('/sale-update/{id?}', [DocumentController::class, 'updateDocumentSale']);
            Route::get('/sale-delete/{id?}', [DocumentController::class, 'updateDocumentSale']);
            Route::get('/sale-print/{id?}', [DocumentController::class, 'updateDocumentSale']);

            Route::get('/write-off', [DocumentController::class, 'indexDocumentWriteOff']);
            Route::get('/write-off-update/{id?}', [DocumentController::class, 'updateDocumentWriteOff']);
            Route::get('/write-off-delete/{id}', [DocumentController::class, 'updateDocumentWriteOff']);
            Route::get('/write-off-print/{id}', [DocumentController::class, 'updateDocumentWriteOff']);
        });
        Route::group(['prefix' => 'ajax'], static function () {
            Route::post('/save-category', [CatalogAjaxController::class, 'saveCategory']);
            Route::post('/save-product', [CatalogAjaxController::class, 'saveProduct']);
            Route::post('/save-product-sort', [CatalogAjaxController::class, 'saveSortProduct']);
            Route::post('/delete-image', [CatalogAjaxController::class, 'deleteImage']);
            Route::post('/add-property', [CatalogAjaxController::class, 'addProperty']);
            Route::post('/add-property-self', [CatalogAjaxController::class, 'addPropertySelf']);
            Route::post('/add-coupon', [CatalogAjaxController::class, 'addCoupon']);
            Route::post('/delete-coupon', [CatalogAjaxController::class, 'deleteCoupon']);
            Route::post('/gift-coupon', [CatalogAjaxController::class, 'giftCoupon']);
            Route::post('/save-property-self', [CatalogAjaxController::class, 'savePropertySelf']);
            Route::post('/delete-property', [CatalogAjaxController::class, 'deleteProperty']);
            Route::post('/save-property', [CatalogAjaxController::class, 'saveProperty']);
            Route::post('/delete-property-model', [CatalogAjaxController::class, 'deletePropertyModel']);
            Route::post('/show-rate-currency', [CurrencyAjaxController::class, 'showRateCurrency']);
            Route::post('/get-product', [DocumentAjaxController::class, 'getProduct']);
            Route::post('/index-document', [DocumentAjaxController::class, 'indexDocumentRoute']);
            Route::post('/save-document', [DocumentAjaxController::class, 'saveDocumentRoute']);
            Route::post('/posting-document', [DocumentAjaxController::class, 'postingDocumentRoute']);
            Route::post('/load-document', [DocumentAjaxController::class, 'loadDocument']);
            Route::post('/load-product', [DocumentAjaxController::class, 'loadProduct']);
            Route::post('/load-product-content', [DocumentAjaxController::class, 'loadProductContent']);
            Route::post('/delete-document', [DocumentAjaxController::class, 'deleteDocument']);
            Route::post('/delete-document-content', [DocumentAjaxController::class, 'deleteDocumentContent']);
            Route::post('/create-write-off-from-front', [DocumentAjaxController::class, 'createWriteOffFromFront']);
            Route::post('/invoice-fast-create', [DocumentAjaxController::class, 'invoiceFastCreate']);
            Route::post('/storage-update', [StorageAjaxController::class, 'storageUpdatePriceOut']);
        });
    });
});