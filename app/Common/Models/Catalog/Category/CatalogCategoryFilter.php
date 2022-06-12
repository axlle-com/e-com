<?php

namespace App\Common\Models\Catalog\Category;

use App\Common\Models\Main\QueryFilter;

class CatalogCategoryFilter extends QueryFilter
{
    public function _filter(): static
    {
        $this->builder->select([
            'ax_catalog_category.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
            'ren.name as render_name',
        ])
            ->leftJoin('ax_catalog_category as par', 'ax_catalog_category.category_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_catalog_category.render_id', '=', 'ren.id');
        return $this;
    }
}
