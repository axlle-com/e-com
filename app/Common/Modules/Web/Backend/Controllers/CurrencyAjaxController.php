<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Wallet\Currency;
use Illuminate\Http\JsonResponse;

class CurrencyAjaxController extends WebController
{
    public function showRateCurrency(): JsonResponse
    {
        if ($post = $this->validation(Currency::rules('show_rate'))) {
            $curr = Currency::showRateCurrency($post);
            return $this->setData($curr)->response();
        }
        return $this->error();
    }
}
