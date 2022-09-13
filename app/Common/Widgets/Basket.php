<?php

namespace App\Common\Widgets;

use Illuminate\View\View;
use App\Common\Models\User\UserWeb;
use App\Common\Models\Catalog\CatalogBasket;

class Basket extends Widget
{
    public function run(): View
    {
        $url = $_SERVER['REQUEST_URI'];
        if (strripos($url, '/user/order') === false) {
            $user = UserWeb::auth();
            $data = CatalogBasket::getBasket($user->id ?? null);
        }
        return view('widgets.basket_mini', ['models' => $data ?? []]);
    }
}
