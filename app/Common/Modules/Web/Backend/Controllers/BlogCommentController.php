<?php

namespace App\Common\Modules\Web\Backend\Controllers;

use App\Common\Http\Controllers\BackendController;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Comment\Comment;

class BlogCommentController extends BackendController
{
    public function index()
    {
        $post = $this->request();
        $title = 'Список комментариев';
        $models = Comment::forBlog()->get();
        return $this->view('backend.blog.comment_index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new PostCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function update(int $id = null)
    {
        $title = 'Новая категория';
        $model = new Comment();
        /** @var $model Comment */
        if($id) {
            if( !$model = Comment::query()->find($id)) {
                abort(404);
            }
            $title = 'Комментарий ' . $model->id;
        }

        return $this->view('backend.blog.category_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new PostCategory)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }

    public function delete(int $id = null)
    {
        /** @var $model Comment */
        if($id && $model = Comment::query()
                ->where('id', $id)
                ->first()) {
            $model->delete();
        }

        return back();
    }

}
