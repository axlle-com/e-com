<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserAjaxController extends WebController
{
    public function login(): Response|JsonResponse
    {
        if ($this->isCookie() && $post = $this->validation(UserWeb::rules())) {
            if (($user = UserWeb::validate($post)) && $user->login()) {
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();
                $basket = CatalogBasket::toggleType($post);
                $this->setMessage('Вы авторизовались');
                $this->setData(['redirect' => '/user/profile']);
                return $this->response();
            }
            return $this->error(self::ERROR_BAD_REQUEST, 'Пользователь не найден');
        }
        return $this->error();
    }

    public function registration(): Response|JsonResponse
    {
        if ($this->isCookie() && $post = $this->validation(UserWeb::rules('registration'))) {
            $user = UserWeb::create($post);
            if (!$user->getErrors() && $user->login()) {
                $this->setMessage('Вы авторизовались');
                $this->setData(['redirect' => '/user/profile']);
                return $this->response();
            }
            return $this->setErrors($user->getErrors())->badRequest()->error();
        }
        return $this->error();
    }
}

