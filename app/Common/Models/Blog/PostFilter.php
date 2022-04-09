<?php

namespace App\Common\Models\Blog;

use App\Common\Components\QueryFilter;

class PostFilter extends QueryFilter
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
            'ax_post.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
        ])
            ->leftJoin('ax_post_category as par', 'ax_post.category_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_post.render_id', '=', 'ren.id');
        return $this;
    }
}
