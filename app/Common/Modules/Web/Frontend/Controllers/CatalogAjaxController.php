<?php

namespace App\Common\Modules\Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;
use App\Common\Models\Catalog\CatalogBasket;

class CatalogAjaxController extends WebController
{
    public function basketAdd()
    {
        if ($post = $this->validation(['product_id' => 'required|integer'])) {
            if ($user = $this->getUser()) {
                $post['user_id'] = $user->id;
                $post['ip'] = $this->getIp();
            }
            $basket = CatalogBasket::create($post);
            return $this->setData($basket)->gzip();
        }
        return $this->error();
    }
}
