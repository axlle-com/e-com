<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Document\CatalogOrder;
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
        if ($post = $this->validation(CatalogOrder::rules('create'))) {
            if (!$user = $this->getUser()) {
                $user = UserWeb::createOrUpdateFromOrder($post);
                if ($user->getErrors() || !$user->login()) { # TODO non auth
                    return $this->setErrors($user->getErrors())->error();
                }
            }
            $user->createOrder($post);
            if ($user->getErrors()) {
                return $this->setErrors($user->getErrors())->error();
            }
            return $this->setData(['url' => '/user/order-pay'])->gzip();
        }
        return $this->error();
    }
}
