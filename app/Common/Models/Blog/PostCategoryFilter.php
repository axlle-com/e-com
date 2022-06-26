<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Main\QueryFilter;

class PostCategoryFilter extends QueryFilter
{
    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([
            'ax_post_category.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
            'ip.ip as ip',
        ])
            ->leftJoin('ax_main_events as ev', static function ($join) use ($table) {
                $join->on('ev.resource_id', '=', $table . '.id')
                    ->where('ev.resource', '=', $table)
                    ->where('ev.event', '=', 'created');
            })
            ->leftJoin('ax_user as user', 'ev.user_id', '=', 'user.id')
            ->leftJoin('ax_main_ips as ip', 'ev.ips_id', '=', 'ip.id')
            ->leftJoin('ax_post_category as par', 'ax_post_category.category_id', '=', 'par.id')
            ->leftJoin('ax_render as ren', 'ax_post_category.render_id', '=', 'ren.id');
        return $this;
    }
}
