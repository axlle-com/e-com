<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\BackendController;
use App\Common\Models\Page\Page;

class PageAjaxController extends BackendController
{
    public function indexPage()
    {
        $post = $this->request();
        $title = 'Список страниц';
        $models = Page::filterAll($post, 'category');

        return $this->view('backend.page.page_index',
            ['errors' => $this->getErrors(), 'breadcrumb' => (new Page())->breadcrumbAdmin('index'), 'title' => $title,
             'models' => $models, 'post' => $post,]
        );
    }

    public function updatePage(int $id = null)
    {
        if ($post = $this->validation(Page::rules())) {
            if ($user = $this->getUser()) {
                $arr['user'] = $this->getUser();
                $arr['user_id'] = $user->id;
                $arr['ip'] = $this->getIp();
                $post = array_merge($arr, $post);
            }
            $model = Page::createOrUpdate($post);
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);

                return $this->badRequest()->error();
            }
            $view = $this->view('backend.page.page_update',
                ['errors' => $this->getErrors(), 'breadcrumb' => (new Page)->breadcrumbAdmin(),
                 'title'  => 'Страница '.$model->title, 'model' => $model, 'post' => $this->request(),]
            )->renderSections()['content'];
            $data = ['view' => _clear_soft_data($view), 'url' => '/admin/page/update/'.$model->id,];

            return $this->setData($data)->response();
        }

        return $this->error();
    }
}
