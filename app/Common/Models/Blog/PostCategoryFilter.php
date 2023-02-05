<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Main\QueryFilter;

class PostCategoryFilter extends QueryFilter
{
    protected array $safeFields = [
        'category_id',
        'render_id',
        'is_published',
        'is_favourites',
        'title',
        'description',
        'created_at',
        'date',
    ];

    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([
            'ax_post_category.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
        ])->leftJoin('ax_post_category as par', 'ax_post_category.category_id', '=',
            'par.id')->leftJoin('ax_render as ren', 'ax_post_category.render_id', '=', 'ren.id')->joinHistory();

        return $this;
    }
}
