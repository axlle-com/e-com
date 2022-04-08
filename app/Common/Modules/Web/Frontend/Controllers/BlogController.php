<?php

namespace App\Common\Modules\Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Page\Page;

class BlogController extends WebController
{
    public function category($model)
    {
        /* @var $model PostCategory */
        $post = $this->request();
        $title = 'Список постов';
        $page = isset($model->render->name) ? 'render.' . $model->render->name : 'blog.page';
        return view('frontend.' . $page, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new PostCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'models' => $model,
            'post' => $post,
        ]);
    }

    public function post($model)
    {
        /* @var $model Post */
        $post = $this->request();
        $title = 'Пост';
        $page = isset($model->render->name) ? 'render.' . $model->render->name : 'blog.page';
        return view('frontend.' . $page, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Post)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $post,
        ]);
    }

    public function page($model)
    {
        /* @var $model Page */
        $post = $this->request();
        $title = 'Текстовая страница';
        $page = isset($model->render->name) ? 'render.' . $model->render->name : 'blog.page';
        return view('frontend.' . $page, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Page())->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $post,
        ]);
    }
}
