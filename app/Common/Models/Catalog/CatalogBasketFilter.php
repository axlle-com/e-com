<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\QueryFilter;
use App\Common\Models\Main\Status;

class CatalogBasketFilter extends QueryFilter
{
    protected array $safeFields = [
        'user_id',
        'catalog_product_id',
    ];

    public function _filter(): static
    {
        $this->builder->select([
            $this->table('*'),
            'p.alias as alias',
            'p.title as title',
            'p.image as image',
            'p.is_single as is_single',
            'storage.price_out as price',
            'storage.in_stock',
            'storage.in_reserve',
            'storage.reserve_expired_at',
        ])
            ->join('ax_catalog_product as p', 'p.id', '=', $this->table('catalog_product_id'))
            ->join('ax_catalog_storage as storage', 'storage.catalog_product_id', '=', 'p.id')
            ->where($this->table('status'), '>', Status::STATUS_POST);
        return $this;
    }

}
