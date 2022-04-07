<?php

namespace App\Common\Modules\Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;

class BlogController extends WebController
{
    public function category($model)
    {
        /* @var $model PostCategory */
        $post = $this->request();
        $title = 'Блог';
        $models = PostCategory::filterAll($post, 'category');
        return view('frontend.blog.category', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new PostCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'models' => $model->posts,
            'post' => $post,
        ]);
    }

    public function post($model)
    {
        $post = $this->request();
        $title = 'Список постов';
        $models = Post::filterAll($post, 'category');
        return view('frontend.blog.post', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Post)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $post,
        ]);
    }

    public function page($model)
    {
        $post = $this->request();
        $title = 'Список постов';
        $models = Post::filterAll($post, 'category');
        return view('frontend.blog.page', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Post)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $post,
        ]);
    }
}
