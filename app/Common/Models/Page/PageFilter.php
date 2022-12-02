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
        $table = $this->table();
        $this->builder->select([
            'ax_page.*',
            'ren.title as render_title',
            'ren.name as render_name',
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
            ->leftJoin('ax_render as ren', 'ax_page.render_id', '=', 'ren.id');
        return $this;
    }
}
