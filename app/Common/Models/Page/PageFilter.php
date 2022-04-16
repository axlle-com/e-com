<?php

namespace App\Common\Models\Page;

use App\Common\Models\Main\QueryFilter;

class PageFilter extends QueryFilter
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
            'ax_page.*',
            'ax_page_type.title as type_title',
            'ax_page_type.resource as type_resource',
            'ren.title as render_title',
            'ren.name as render_name',
        ])
            ->leftJoin('ax_page_type', 'ax_page.page_type_id', '=', 'ax_page_type.id')
            ->leftJoin('ax_render as ren', 'ax_page.render_id', '=', 'ren.id');
        return $this;
    }
}
