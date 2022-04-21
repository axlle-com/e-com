<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogBasket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CatalogAjaxController extends WebController
{
    public function basketAdd(): Response|JsonResponse
    {
        if ($post = $this->validation(['catalog_product_id' => 'required|integer'])) {
            if ($user = $this->getUser()) {
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();
            }
            $basket = CatalogBasket::setBasket($post);
            return $this->setData($basket)->gzip();
        }
        return $this->error();
    }

    public function basketClear(): Response
    {
        if ($user = $this->getUser()) {
            $post['user_id'] = $user->id;
            $post['ip'] = $this->getIp();
        }
        CatalogBasket::clearUserBasket($post['user_id'] ?? null);
        return $this->gzip();
    }
}
