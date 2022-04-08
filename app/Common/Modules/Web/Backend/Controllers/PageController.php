<?php

namespace App\Common\Modules\Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Page\Page;

class PageController extends WebController
{
    public function indexPage()
    {
        $post = $this->request();
        $title = 'Список страниц';
        $models = Page::filterAll($post, 'category');
        return view('backend.page.page_index', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Page())->breadcrumbAdmin('index'),
            'title' => $title,
            'models' => $models,
            'post' => $post,
        ]);
    }

    public function updatePage(int $id = null)
    {
        $title = 'Новая страница';
        $model = new Page();
        /* @var $model Page */
        if ($id) {
            $model = Page::query()
                ->with(['galleryWithImages'])
                ->where('id', $id)
                ->first();
            $title = 'Страница ' . $model->title;
        }

        return view('backend.page.page_update', [
            'errors' => $this->getErrors(),
            'breadcrumb' => (new Page)->breadcrumbAdmin(),
            'title' => $title,
            'model' => $model,
            'post' => $this->request(),
        ]);
    }

    public function deletePage(int $id = null)
    {
        /* @var $model Page */
        if ($id && $model = Page::query()->with(['galleryWithImages'])->where('id', $id)->first()) {
            $model->delete();
        }
        return back();
    }
}
