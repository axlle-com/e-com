<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Document\Order\DocumentOrder;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\User\UserWeb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CatalogAjaxController extends WebController
{
    public function basketAdd(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogBasket::rules('update'))) {
            if ($user = $this->getUser()) {
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();
            }
            $basket = CatalogBasket::addBasket($post);
            return $this->setData($basket)->gzip();
        }
        return $this->error();
    }

    public function basketChange(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogBasket::rules('update'))) {
            if ($user = $this->getUser()) {
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();
            }
            $basket = CatalogBasket::changeBasket($post);
            return $this->setData($basket)->gzip();
        }
        return $this->error();
    }

    public function basketDelete(): Response|JsonResponse
    {
        if ($post = $this->validation(CatalogBasket::rules('delete'))) {
            if ($user = $this->getUser()) {
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();
            }
            $basket = CatalogBasket::deleteBasket($post);
            return $this->setData($basket)->gzip();
        }
        return $this->error();
    }

    public function basketClear(): Response|JsonResponse
    {
        if ($user = $this->getUser()) {
            $post['user_id'] = $user->id;
        }
        CatalogBasket::clearUserBasket($post['user_id'] ?? null);
        return $this->gzip();
    }

    public function orderSave(): Response|JsonResponse
    {
        if ($post = $this->validation(DocumentOrder::rules())) {
            if ($err = DocumentOrder::validate($post)) {
                return $this->setErrors(_Errors::error($err, $this))->error();
            }
            if (!$user = $this->getUser()) {
                $userSession = session('_user_guest', []);
                if (empty($userSession['phone']) || _clear_phone($userSession['phone']) !== _clear_phone($post['user']['phone'])) {
                    return $this->setErrors(_Errors::error(['user.phone' => 'Необходимо подтвердить телефон'], $this))
                                ->error();
                }
                $post['user']['password'] = _gen_password();
                $post['user']['is_phone'] = 1;
                $user = UserWeb::createOrUpdate($post['user'] ?? null);
                if ($user->getErrors() || !$user->login()) { # TODO ? may be non auth or no
                    return $this->setErrors($user->getErrors())->error();
                }
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();
                $basket = CatalogBasket::toggleType($post);
            }
            if (!$user->is_phone) {
                return $this->setErrors(_Errors::error(['user.phone' => 'Необходимо подтвердить телефон'], $this))
                            ->error();
            }
            if ($user->createOrder($post)->getErrors()) {
                return $this->setErrors($user->getErrors())->error();
            }
            return $this->setData(['redirect' => '/user/order-confirm'])->gzip();
        }
        return $this->error();
    }

    public function orderPay(): Response|JsonResponse
    {
        if ($user = $this->getUser()) {
            if (($order = DocumentOrder::getByUser($user->id)) && !$error = $order->posting()->getErrors()) {
                return $this->setData(['redirect' => $order->paymentUrl])->gzip();
            }
            if (!empty($error)) {
                $this->setErrors($error);
            }
            return $this->error(self::ERROR_UNKNOWN, $this->getErrors()?->getMessage() ?: 'Заказ не найден');
        }
        return $this->error();
    }
}
