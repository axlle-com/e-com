<?php

namespace Application\v1\Controllers;

use App\Common\Http\Controllers\AppController;
use App\Common\Models\User\UserApp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends AppController
{
    public function logout(): Response|JsonResponse
    {
        /* @var $user UserApp */
        if (($user = $this->getUser()) && $user->logout()) {
            return $this->response();
        }
        return $this->error();
    }

    public function registration(): Response|JsonResponse
    {
        if ($post = $this->validation(UserApp::rules('registration'))) {
            $user = UserApp::create($post);
            if ($error = $user->getErrors()) {
                $this->setErrors($error);
                return $this->badRequest()->error();
            }
            if ($user->login()) {
                $this->setData($user->authFields());
                return $this->response();
            }
            return $this->badRequest()->error('Не удалось создать токен');
        }
        return $this->error();
    }

    public function login(): Response|JsonResponse
    {
        /* @var $user UserApp */
        if ($post = $this->validation(UserApp::rules())) {
            if (($user = UserApp::validate($post)) && $user->login()) {
                $this->setData($user->authFields());
                return $this->response();
            }
            return $this->notFound()->error();
        }
        return $this->error();
    }

    public function test(): Response|JsonResponse
    {
        $this->setData($this->getUser());
        return $this->response();
    }
}
