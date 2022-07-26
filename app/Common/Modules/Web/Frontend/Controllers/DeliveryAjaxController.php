<?php

namespace Web\Frontend\Controllers;

use App\Common\Components\Delivery\Cdek;
use App\Common\Components\Delivery\DaDataClient;
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
//            $models = DaDataClient::address($post['term']);
            _dd_((new Cdek(['size' => 6000, 'country_codes' => 'RU'], 'v2/location/cities'))->get());
            return $this->setData('$models')->response();
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

    public function getObject(): Response|JsonResponse
    {
        if ($post = $this->validation(['id' => 'required|string'])) {
            $start = microtime(true);
            $data = [
                'calculate' => Cdek::calculate(['to_location' => ['code' => $post['id']]]),
                'coordinates' => Cdek::coordinates($post['id']),
            ];
            if (!$data['calculate'] || !$data['coordinates']) {
                return $this->error(self::ERROR_BAD_REQUEST, 'Не удалось загрузить данные по выбранному региону');
            }
            $data['time'] = microtime(true) - $start;
            return $this->setData($data)->response();
        }
        return $this->error();
    }

    public function getDeliveryInfo(): Response|JsonResponse
    {
        $data = Cdek::getPvz();
        $data['ip'] = DaDataClient::ip();
//        $data['tariff'] = Cdek::calculate([]);
        return $this->setData($data)->response();
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

