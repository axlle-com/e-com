<?php

namespace App\Common\Models\Catalog\Product;

use App\Common\Models\Main\QueryFilter;

class CatalogProductFilter extends QueryFilter
{
    protected array $safeFields = [
        'category_id',
        'render_id',
        'is_published',
        'is_favourites',
        'title',
        'description',
    ];

    public function _filter(): static
    {
        $this->builder->select([
            'ax_catalog_product.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
            'ren.name as render_name',
        ])
            ->leftJoin('ax_catalog_category as par', 'ax_catalog_product.category_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_catalog_product.render_id', '=', 'ren.id');
        return $this;
    }

}
