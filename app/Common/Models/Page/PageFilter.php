<?php

namespace App\Common\Models\Page;

use App\Common\Components\QueryFilter;

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
            'par.title as type_title',
            'ren.title as render_title',
        ])
            ->leftJoin('ax_page_type as par', 'ax_page.page_type_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_page.render_id', '=', 'ren.id');
        return $this;
    }
}
