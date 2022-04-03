<?php

namespace App\Common\Modules\Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use Illuminate\Http\JsonResponse;

class BlogAjaxController extends WebController
{
    public function saveCategory(): JsonResponse
    {
        if ($post = $this->validation(PostCategory::rules())) {
            $model = PostCategory::createOrUpdate($post);
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                return $this->badRequest()->error();
            }
            $view = view('backend.blog.category_update', [
                'errors' => $this->getErrors(),
                'breadcrumb' => (new PostCategory)->breadcrumbAdmin(),
                'title' => 'Категория ' . $model->title,
                'model' => $model,
                'post' => $this->request(),
            ])->renderSections()['content'];
            $data = [
                'view' => $view,
                'url' => '/admin/blog/category-update/' . $model->id,
            ];
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function updateCategory(int $id = null)
    {
        $title = 'Новая категория';
        $model = new PostCategory();
        /* @var $model PostCategory */
        if ($id && $model = PostCategory::query()->where('id', $id)->first()) {
            $title = 'Категория ' . $model->title;
        }
        return view('backend.blog.category_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new PostCategory)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }

    public function indexPost()
    {
        $post = $this->request();
        $title = 'Список постов';
        $models = Post::filterAll($post);
        return view('backend.blog.post_index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Post)->breadcrumbAdmin(),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function updatePost(int $id = null)
    {
        $title = 'Статья';
        $model = new Post();
        /* @var $model Post */
        if ($id && $model = Post::query()->where('id', $id)->first()) {
            $title .= ' ' . $model->title;
        }
        return view('backend.blog.post_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Post)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }
}
