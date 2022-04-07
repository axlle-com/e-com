<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Page\Page;
use App\Common\Modules\Web\Frontend\Controllers\BlogController;
use Illuminate\Http\Request;

class SiteController extends WebController
{
    public function index()
    {
        return view('frontend.index');
    }

    public function route(Request $request, $alias)
    {
        if ($model = Page::query()->where('alias', $alias)->first()) {
            return (new BlogController($request))->page($model);
        }
        if ($model = PostCategory::query()->where('alias', $alias)->first()) {
            return (new BlogController($request))->category($model);
        }
        if ($model = Post::query()->where('alias', $alias)->first()) {
            return (new BlogController($request))->post($model);
        }
        abort(404);
    }
}
