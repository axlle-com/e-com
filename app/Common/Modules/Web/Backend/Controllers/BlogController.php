<?php

namespace App\Common\Modules\Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;

class BlogController extends WebController
{
    public function indexCategory()
    {
        $post = $this->request();
        $title = 'Список категорий';
        $models = PostCategory::filterAll($post, 'category');
        return view('backend.blog.category_index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new PostCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function updateCategory(int $id = null)
    {
        $title = 'Новая категория';
        $model = new PostCategory();
        /* @var $model PostCategory */
        if ($id) {
            $model = PostCategory::query()
                ->with(['galleryWithImages'])
                ->where('id', $id)
                ->first();
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

    public function deleteCategory(int $id = null)
    {
        /* @var $model PostCategory */
        if ($id && $model = PostCategory::query()->with(['galleryWithImages'])->where('id', $id)->first()) {
            $model->delete();
        }
        return back();
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

    public function deletePost(int $id = null)
    {
        /* @var $model Post */
        if ($id && $model = Post::query()->with(['galleryWithImages'])->where('id', $id)->first()) {
            $model->delete();
        }
        return back();
    }
}
