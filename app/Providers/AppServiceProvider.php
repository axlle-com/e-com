<?php

namespace App\Providers;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Blog\PostCategoryObserver;
use App\Common\Models\Blog\PostObserver;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Category\CatalogCategoryObserver;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Document\CatalogDocumentContent;
use App\Common\Models\Catalog\Document\CatalogOrder;
use App\Common\Models\Catalog\Document\CatalogOrderObserver;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Product\CatalogProductObserver;
use App\Common\Models\Main\BaseObserver;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
        CatalogDocument::observe(BaseObserver::class);
        CatalogDocumentContent::observe(BaseObserver::class);
        CatalogOrder::observe(CatalogOrderObserver::class);
        CatalogBasket::observe(BaseObserver::class);
        CatalogCategory::observe(CatalogCategoryObserver::class);
        CatalogProduct::observe(CatalogProductObserver::class);
    }
}
