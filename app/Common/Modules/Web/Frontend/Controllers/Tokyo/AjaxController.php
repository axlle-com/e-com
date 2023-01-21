<?php

namespace Web\Frontend\Controllers\Tokyo;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Page\Page;
use App\Common\Models\Url\MainUrl;
use Illuminate\Http\Request;

class AjaxController extends WebController
{
    public function route(Request $request)
    {
        $post = $this->request();
        if (empty($post['page'])) {
            if ($model = Page::withUrl()->where(MainUrl::table('alias'), 'index')->first()) {
                return $this->page($model);
            }
            return $this->error(self::ERROR_NOT_FOUND);
        }
        if ($model = Page::withUrl()->where(MainUrl::table('alias'), $post['page'])->first()) {
            return $this->page($model);
        }
        if ($model = PostCategory::withUrl()->with(['posts'])->where('alias', $post['page'])->first()) {
            return $this->category($model);
        }
        if ($model = Post::withUrl()->where('alias', $post['page'])->first()) {
            return $this->post($model);
        }
        return $this->error(self::ERROR_NOT_FOUND);
    }

    public function page($model)
    {
        /* @var $model Page */
        $post = $this->request();
        $title = $model->title ?? 'Текстовая страница';
        $page = isset($model->render->name) ? 'render.' . $model->render->name : 'blog.page';
        $view = _view($page, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Page())->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $post,
        ])->renderSections()['content'];
        return $this->setData([
            'url' => $model->alias,
            'view' => _clear_soft_data($view),
        ])->gzip();
    }

    public function category($model)
    {
        /* @var $model PostCategory */
        $post = $this->request();
        $title = $model->title ?? 'Список постов';
        $page = isset($model->render->name) ? 'render.' . $model->render->name : 'blog.page';
        $view = _view($page, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new PostCategory)->breadcrumbAdmin('index'),
            'title' => $title,
            'model' => $model,
            'post' => $post,
        ])->renderSections()['content'];
        return $this->setData([
            'url' => $model->alias,
            'view' => _clear_soft_data($view),
        ])->gzip();
    }

    public function post($model)
    {
        /* @var $model Post */
        $post = $this->request();
        $title = 'Пост';
        $page = isset($model->render->name) ? 'render.' . $model->render->name : 'blog.page';
        $view = _view($page, [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Post)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $post,
        ])->renderSections()['content'];
        return $this->setData([
            'url' => $model->alias,
            'view' => _clear_soft_data($view),
        ])->gzip();
    }

}
