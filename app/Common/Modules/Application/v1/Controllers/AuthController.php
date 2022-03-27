<?php

namespace Application\v1\Controllers;

use App\Common\Http\Controllers\AppController;
use App\Common\Models\User\UserApp;
use Illuminate\Http\JsonResponse;

class AuthController extends AppController
{
    public function login(): JsonResponse
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

    public function logout(): JsonResponse
    {
        if (($user = $this->getUser()) && $user->logout()) {
            return $this->response();
        }
        return $this->error();
    }

    public function registration(): JsonResponse
    {
        if ($post = $this->validation(UserApp::rules('registration'))) {
            $user = UserApp::create($post);
            if ($error = $user->getError()) {
                $this->setError($error);
                return $this->badRequest()->error();
            }
            $this->setData($user->authFields());
            return $this->response();
        }
        return $this->error();
    }

    public function test(): JsonResponse
    {
        $this->setData($this->getUser());
        return $this->response();
    }
}
