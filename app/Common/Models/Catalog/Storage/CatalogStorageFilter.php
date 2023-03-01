<?php

namespace App\Common\Models\Catalog\Storage;

use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\QueryFilter;

class CatalogStorageFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            $this->table('*'),
            CatalogProduct::table('title') . ' as product_title',
            CatalogStoragePlace::table('title') . ' as storage_title',
        ])
            ->leftJoin(CatalogProduct::table(), $this->table('catalog_product_id'), '=', CatalogProduct::table('id'))
            ->leftJoin(CatalogStoragePlace::table(), $this->table('catalog_storage_place_id'), '=', CatalogStoragePlace::table('id'));
        return $this;
    }
}
