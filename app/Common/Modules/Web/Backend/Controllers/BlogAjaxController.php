<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BlogAjaxController extends WebController
{
    public function saveCategory(): Response|JsonResponse
    {
        if ($post = $this->validation(PostCategory::rules())) {
            $post['user'] = $this->getUser();
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
                'view' => _clear_soft_data($view),
                'url' => '/admin/blog/category-update/' . $model->id,
            ];
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function indexuCategory(int $id = null)
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

    public function savePost(): Response|JsonResponse
    {
        if ($post = $this->validation(Post::rules())) {
            if ($user = $this->getUser()) {
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();
            }
            $model = Post::createOrUpdate($post);
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                return $this->badRequest()->error();
            }
            $view = view('backend.blog.post_update', [
                'errors' => $this->getErrors(),
                'breadcrumb' => (new Post)->breadcrumbAdmin(),
                'title' => 'Категория ' . $model->title,
                'model' => $model,
                'post' => $this->request(),
            ])->renderSections()['content'];
            $data = [
                'view' => _clear_soft_data($view),
                'url' => '/admin/blog/post-update/' . $model->id,
            ];
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function indexPost(int $id = null)
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
