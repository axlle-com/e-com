<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Page\Page;
use App\Common\Models\User\UserWeb;

class PageAjaxController extends WebController
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
        if ($post = $this->validation(Page::rules())) {
            $post['user_id'] = UserWeb::auth()->id;
            $model = Page::createOrUpdate($post);
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                return $this->badRequest()->error();
            }
            $view = view('backend.page.page_update', [
                'errors' => $this->getErrors(),
                'breadcrumb' => (new Page)->breadcrumbAdmin(),
                'title' => 'Страница ' . $model->title,
                'model' => $model,
                'post' => $this->request(),
            ])->renderSections()['content'];
            $data = [
                'view' => $view,
                'url' => '/admin/page/update/' . $model->id,
            ];
            return $this->setData($data)->response();
        }
        return $this->error();
    }
}
