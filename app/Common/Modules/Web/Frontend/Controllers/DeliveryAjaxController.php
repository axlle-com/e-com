<?php

namespace Web\Frontend\Controllers;

use App\Common\Components\Delivery\Kladr;
use App\Common\Components\Mail\AccountRestorePassword;
use App\Common\Http\Controllers\WebController;
use App\Common\Models\User\RestorePasswordToken;
use App\Common\Models\User\User;
use App\Common\Models\User\UserGuest;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class DeliveryAjaxController extends WebController
{
    public function city(): Response|JsonResponse
    {
        if ($post = $this->validation(['term' => 'required|string'])) {
            $data = ['query' => $post['term']];
            $models = (new Kladr($data))->city();
            return $this->setData($models)->response();
        }
        return $this->error();
    }

    public function goods(): Response|JsonResponse
    {
        $models = ['goods' => [
            [
                'length' => 10,
                'width' => 10,
                'height' => 10,
                'weight' => 100
            ],
        ]];
        return $this->setData($models)->response();
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

    public function activatePhone(): Response|JsonResponse
    {
        /* @var $user UserWeb */
        if ($this->isCookie() && $post = $this->validation(['phone' => 'required|string'])) {
            if ($user = UserWeb::auth()) {
                if ($user->sendCodePassword($post)) {
                    $this->setMessage('Код подтверждения выслан');
                    return $this->response();
                }
            } else if ((new UserGuest())->sendCodePassword($post)) {
                $this->setMessage('Код подтверждения выслан');
                return $this->response();
            }
            return $this->setMessage('Не удалось отправить, повторите позднее')->badRequest()->error();
        }
        return $this->error();
    }

    public function activatePhoneCode(): Response|JsonResponse
    {
        /* @var $user UserWeb */
        if ($this->isCookie() && $post = $this->validation(['code' => 'required|string'])) {
            if ($user = UserWeb::auth()) {
                if ($user->validateCode($post)) {
                    $this->setMessage('Код подтвержден');
                    return $this->response();
                }
            } else if ((new UserGuest())->validateCode($post)) {
                $this->setMessage('Код подтвержден');
                return $this->response();
            }
            return $this->setMessage('Не верный код, повторите через 15 мин или введите правильный код')->badRequest()->error();
        }
        return $this->error();
    }

    public function restorePassword(): Response|JsonResponse
    {
        /* @var $user UserWeb */
        if ($this->isCookie() && $post = $this->validation(['email' => 'required|string'])) {
            if (($user = UserWeb::findByLogin($post['email'])) && (new RestorePasswordToken)->create($user)) {
                Mail::to($user->email)->send(new AccountRestorePassword($user));
            }
            return $this->setMessage('Ссылка для восстановления пароля выслана на вашу почту, если вы зарегистрированы в системе')->response();
        }
        return $this->error();
    }

    public function changePassword(): Response|JsonResponse
    {
        /* @var $user UserWeb */
        if ($this->isCookie() && $post = $this->validation(User::rules('change_password'))) {
            if (($user = $this->getUser()) && $user->changePassword($post)) {
                if ($user->is_email === 0) {
                    $user->activateMail();
                }
                session(['success' => 'Пароль изменен']);
                $this->setData(['redirect' => '/user/profile']);
                return $this->response();
            }
        }
        return $this->error();
    }
}

