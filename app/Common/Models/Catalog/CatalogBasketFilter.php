<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\QueryFilter;

class CatalogBasketFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            $this->table . '.*',
            'p.alias as alias',
            'p.title as title',
            'p.price as price',
            'p.image as image',
        ])
            ->join('ax_catalog_product as p', 'p.id', '=', $this->table . '.catalog_product_id')
            ->leftJoin('ax_render as ren', 'p.render_id', '=', 'ren.id');
        return $this;
    }

}
