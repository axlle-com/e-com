<?php

namespace Web\Frontend\Controllers;

use Illuminate\Http\Request;
use App\Common\Models\Page\Page;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Http\Controllers\WebController;

class SiteController extends WebController
{
    public function index()
    {
        return _view('index');
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
