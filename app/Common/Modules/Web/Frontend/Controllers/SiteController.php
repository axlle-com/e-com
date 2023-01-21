<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Page\Page;
use App\Common\Models\Url\MainUrl;
use Illuminate\Http\Request;

class SiteController extends WebController
{
    public function index()
    {
        return _view('index');
    }

    public function route(Request $request, $alias)
    {
        if ($model = Page::withUrl()->where(MainUrl::table('alias'), $alias)->first()) {
            return (new BlogController($request))->page($model);
        }
        if ($model = PostCategory::withUrl()->with(['posts'])->where(MainUrl::table('alias'), $alias)->first()) {
            return (new BlogController($request))->category($model);
        }
        if ($model = Post::withUrl()->where(MainUrl::table('alias'), $alias)->first()) {
            return (new BlogController($request))->post($model);
        }
        abort(404);
    }
}
