<?php

namespace App\Providers;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Blog\PostCategoryObserver;
use App\Common\Models\Blog\PostObserver;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Category\CatalogCategoryObserver;
use App\Common\Models\Catalog\Document\CatalogOrder;
use App\Common\Models\Catalog\Document\CatalogOrderObserver;
use App\Common\Models\Catalog\Document\DocumentComing;
use App\Common\Models\Catalog\Document\DocumentComingContent;
use App\Common\Models\Catalog\Document\DocumentReservation;
use App\Common\Models\Catalog\Document\DocumentReservationCancel;
use App\Common\Models\Catalog\Document\DocumentReservationCancelContent;
use App\Common\Models\Catalog\Document\DocumentReservationContent;
use App\Common\Models\Catalog\Document\DocumentSale;
use App\Common\Models\Catalog\Document\DocumentSaleContent;
use App\Common\Models\Catalog\Document\DocumentWriteOff;
use App\Common\Models\Catalog\Document\DocumentWriteOffContent;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Product\CatalogProductObserver;
use App\Common\Models\Main\BaseObserver;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        UserWeb::observe(BaseObserver::class);
        Render::observe(BaseObserver::class);
        Page::observe(BaseObserver::class);
        Post::observe(PostObserver::class);
        PostCategory::observe(PostCategoryObserver::class);
        DocumentComing::observe(BaseObserver::class);
        DocumentComingContent::observe(BaseObserver::class);
        DocumentReservation::observe(BaseObserver::class);
        DocumentReservationContent::observe(BaseObserver::class);
        DocumentReservationCancel::observe(BaseObserver::class);
        DocumentReservationCancelContent::observe(BaseObserver::class);
        DocumentSale::observe(BaseObserver::class);
        DocumentSaleContent::observe(BaseObserver::class);
        DocumentWriteOff::observe(BaseObserver::class);
        DocumentWriteOffContent::observe(BaseObserver::class);
        CatalogOrder::observe(CatalogOrderObserver::class);
        CatalogBasket::observe(BaseObserver::class);
        CatalogCategory::observe(CatalogCategoryObserver::class);
        CatalogProduct::observe(CatalogProductObserver::class);
    }
}
