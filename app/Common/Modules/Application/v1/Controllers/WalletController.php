<?php

namespace Application\v1\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Common\Models\Wallet\Wallet;
use App\Common\Models\Errors\_Errors;
use App\Common\Http\Controllers\AppController;
use App\Common\Models\Wallet\WalletTransaction;
use App\Common\Models\Wallet\WalletTransactionFilter;

class WalletController extends AppController
{
    public function setWallet(): Response|JsonResponse
    {
        if ($post = $this->validation(Wallet::rules())) {
            $post['user_id'] = $this->getUser()->id;
            $wallet = Wallet::create($post);
            if ($error = $wallet->getErrors()) {
                $this->setErrors($error);
                return $this->badRequest()->error();
            }
            $this->setData($wallet->getFields());
            return $this->response();
        }
        return $this->error();
    }

    public function getWallet(): Response|JsonResponse
    {
        $post['user_id'] = $this->getUser()->id;
        $wallet = Wallet::find($post);
        if ($error = $wallet->getErrors()) {
            $this->setErrors($error);
            return $this->badRequest()->error();
        }
        $this->setData($wallet->getFields());
        return $this->response();
    }

    public function getTransaction(): Response|JsonResponse
    {
        if ($post = $this->validation(WalletTransactionFilter::rules())) {
            $post['user_id'] = $this->getUser()->id;
            if ($this->getUser()->wallet) {
                $data = WalletTransactionFilter::builder($post)->apply()->get();
                $this->setData($data);
                return $this->response();
            }
            return $this->setErrors(_Errors::error('У пользователя нет кошелька', $this))->badRequest()->error();
        }
        return $this->error();
    }

    public function setTransaction(): Response|JsonResponse
    {
        if ($post = $this->validation(WalletTransaction::rules())) {
            $post['user_id'] = $this->getUser()->id;
            $post['wallet'] = $this->getUser()->wallet;
            if ($post['wallet']) {
                $data = WalletTransaction::create($post);
                if ($error = $data->getErrors()) {
                    $this->setErrors($error);
                    return $this->badRequest()->error();
                }
                $this->setData($data->getFields());
                return $this->response();
            }
            return $this->setErrors(_Errors::error('У пользователя нет кошелька', $this))->badRequest()->error();
        }
        return $this->error();
    }
}
