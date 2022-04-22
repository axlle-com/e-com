<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\JsonResponse;

class UserAjaxController extends WebController
{
    public function login(): JsonResponse
    {
        if ($post = $this->validation(UserWeb::rules())) {
            if (($user = UserWeb::validate($post)) && $user->login()) {
                $this->setMessage('Вы авторизовались');
                return $this->response();
            }
            return $this->error(self::ERROR_BAD_REQUEST, 'Пользователь не найден');
        }
        return $this->error();
    }

    public function registration(): JsonResponse
    {
        if ($post = $this->validation(UserWeb::rules('registration'))) {
            if (($user = UserWeb::validate($post)) && $user->login()) {
                $this->setMessage('Вы авторизовались');
                return $this->response();
            }
        }
        return $this->error();
    }
}

