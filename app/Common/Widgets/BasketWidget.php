<?php

namespace App\Common\Widgets;

use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\User\UserWeb;
use Illuminate\View\View;

class BasketWidget extends Widget
{
    public function run(): View
    {
        $user = UserWeb::auth();
        $data = CatalogBasket::getBasket($user->id ?? null);
        return $this->render('basket_mini', ['models' => $data]);
    }
}
