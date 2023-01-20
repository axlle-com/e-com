<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Wallet\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CurrencyAjaxController extends WebController
{
    public function showRateCurrency(): Response|JsonResponse
    {
        if ($post = $this->validation(Currency::rules('show_rate'))) {
            $curr = Currency::showRateCurrency($post);
            return $this->setData($curr)->response();
        }
        return $this->error();
    }
}
