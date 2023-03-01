<?php

namespace App\Common\Models\Blog;

use App\Common\Models\History\MainHistory;
use App\Common\Models\Main\QueryFilter;
use App\Common\Models\Render;

class PostFilter extends QueryFilter
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
        'user_id',
        'title',
        'id',
    ];

    public function _filter(): static
    {
        $this->builder->select([
            'ax_post.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
        ])
            ->leftJoin(PostCategory::table() . ' as par', $this->table('category_id'), '=', 'par.id')
            ->leftJoin(Render::table() . ' as ren', $this->table('render_id'), '=', 'ren.id')
            ->joinHistory();

        return $this;
    }

    public function user_id(?int $value): void
    {
        if(!$value) {
            return;
        }
        $this->builder->where(MainHistory::table('user_id'), $value);
    }
}
