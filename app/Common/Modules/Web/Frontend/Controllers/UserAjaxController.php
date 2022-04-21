<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Facades\Validator;

class UserAjaxController extends WebController
{
    public function login()
    {
        $post = $this->request();
        $validator = Validator::make($post, UserWeb::rules());
        if ($validator && $validator->fails()) {
            $this->setErrors($validator->messages()->toArray());
        } elseif ($validator === false) {
            $this->setErrors();
        } else {
            $validator->after(function ($validator) use ($post) {
                $email = $post['email'] ?? null;
                $phone = $post['phone'] ?? null;
                if (empty($email) || empty($phone)) {
                    $validator->errors()->add('email', 'Не заполнены обязательные поля');
                    $validator->errors()->add('phone', 'Не заполнены обязательные поля');
                }
            });
            if ($validator->fails()) {
                $this->setErrors($validator->messages()->toArray());
            } elseif ($validator === false) {
                $this->setErrors();
            } else {
                echo 5;
            }
        }
        $this->badRequest()->error();
    }
}

