<?php

namespace Web\Backend\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Common\Models\Wallet\Currency;
use App\Common\Http\Controllers\WebController;

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
