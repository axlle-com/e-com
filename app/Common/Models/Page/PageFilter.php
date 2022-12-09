<?php

namespace App\Common\Models\Page;

use App\Common\Models\History\MainHistory;
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
        $table = $this->table();
        $this->builder->select([
            'ax_page.*',
            'ren.title as render_title',
            'ren.name as render_name',
        ])
            ->leftJoin('ax_render as ren', 'ax_page.render_id', '=', 'ren.id');
        $this->builder = MainHistory::joinHistory($this->builder, $table);
        return $this;
    }
}
