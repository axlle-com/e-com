<?php

namespace App\Providers;

use App\Common\Jobs\ReservationCheckJob;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Blog\PostCategoryObserver;
use App\Common\Models\Blog\PostObserver;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Category\CatalogCategoryObserver;
use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Catalog\Document\Main\DocumentContentBase;
use App\Common\Models\Catalog\Document\Main\DocumentObserver;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Product\CatalogProductObserver;
use App\Common\Models\Comment;
use App\Common\Models\Main\BaseObserver;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\Setting\Setting;
use App\Common\Models\Setting\SettingObserver;
use App\Common\Models\User\User;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
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
        Setting::observe(SettingObserver::class);
        User::observe(BaseObserver::class);
        Render::observe(BaseObserver::class);
        Page::observe(BaseObserver::class);
        Post::observe(PostObserver::class);
        PostCategory::observe(PostCategoryObserver::class);
        DocumentBase::observe(DocumentObserver::class);
        DocumentContentBase::observe(BaseObserver::class);
        CatalogBasket::observe(BaseObserver::class);
        CatalogCategory::observe(CatalogCategoryObserver::class);
        CatalogProduct::observe(CatalogProductObserver::class);
        Comment::observe(BaseObserver::class);
        View::share('user', UserWeb::auth());
        View::share('template', Setting::template());
    }
}
