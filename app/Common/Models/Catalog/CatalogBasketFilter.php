<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\QueryFilter;
use App\Common\Models\Main\Status;

class CatalogBasketFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            $this->table('*'),
            'p.alias as alias',
            'p.title as title',
            'p.price as price',
            'p.image as image',
            'storage.in_stock',
            'storage.in_reserve',
            'storage.reserve_expired_at',
        ])
            ->where($this->table('status'), '>', Status::STATUS_POST)
            ->join('ax_catalog_product as p', 'p.id', '=', $this->table('catalog_product_id'))
            ->leftJoin('ax_render as ren', 'p.render_id', '=', 'ren.id')
            ->leftJoin('ax_catalog_storage as storage', 'storage.catalog_product_id', '=', 'p.id')
            ->where(function ($query) {
                $query->where('storage.in_stock', '>', 0)
                    ->orWhere(static function ($query) {
                        $query->where('storage.in_reserve', '>', 0)
                            ->where('storage.reserve_expired_at', '<', time());
                    });
            });
        return $this;
    }

}
