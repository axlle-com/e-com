<?php

namespace App\Providers;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Blog\PostCategoryObserver;
use App\Common\Models\Blog\PostObserver;
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
        Post::observe(PostObserver::class);
        PostCategory::observe(PostCategoryObserver::class);
    }
}
