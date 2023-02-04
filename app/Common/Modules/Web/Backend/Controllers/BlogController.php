<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\BackendController;
use App\Common\Http\Requests\PostRequest;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BlogController extends BackendController
{
    public function indexCategory()
    {
        $post = $this->request();
        $title = 'Список категорий';
        $models = PostCategory::filterAll($post, 'category');

        return $this->view('backend.blog.category_index', [
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
        /** @var $model PostCategory */
        if($id) {
            if( !$model = PostCategory::oneWith($id, ['manyGalleryWithImages'])) {
                abort(404);
            }
            $title = 'Категория ' . $model->title;
        }

        return $this->view('backend.blog.category_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new PostCategory)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }

    public function deleteCategory(int $id = null)
    {
        /** @var $model PostCategory */
        if($id && $model = PostCategory::query()
                ->with(['manyGalleryWithImages'])
                ->where('id', $id)
                ->first()) {
            $model->delete();
        }

        return back();
    }

    public function indexPost()
    {
        $post = $this->request();
        $title = 'Список постов';
        $models = Post::filterAll($post);

        return $this->view('backend.blog.post_index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Post)->breadcrumbAdmin(),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function indexPostForm(PostRequest $request): Response|JsonResponse
    {
        $post = $request->all();
        $models = Post::filterAll($post);
        $view = $this->view('backend.blog.post_index', [
            'models' => $models,
        ])
            ->renderSections()['content'];
        $this->setData([
            'view' => $view,
        ]);

        return $this->response();
    }

    public function updatePost(PostRequest $request, int $id = null)
    {
        $title = 'Статья';
        $model = new Post();
        /** @var $model Post */
        if($id && $model = Post::oneWith($id, ['manyGalleryWithImages'])) {
            $title .= ' ' . $model->title;
        }

        return $this->view('backend.blog.post_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Post)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }

    public function deletePost(int $id = null)
    {
        /** @var $model Post */
        if($id && $model = Post::query()
                ->with(['manyGalleryWithImages'])
                ->where('id', $id)
                ->first()) {
            $model->delete();
        }

        return back();
    }
}
