<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\User;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\Request;

class UserAjaxController extends WebController
{
    public function profile(Request $request)
    {
        if ($post = $this->validation([])) {
            $user = UserWeb::auth();
            $model = User::createOrUpdate($post);
            if ($errors = $model->getErrors()) {
                $this->setErrors($errors);
                return $this->badRequest()->error();
            }
            $view = view('backend.user.update', [
                'model' => $model,
                'title' => 'Пользователь: ' . $model->first_name,
            ])->renderSections()['content'];
            $data = ['view' => _clear_soft_data($view),];
            return $this->setData($data)->response();
        }
        return $this->error();
    }
}
