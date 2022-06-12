<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Main\QueryFilter;

class CatalogOrderFilter extends QueryFilter
{
    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([
            $this->table('*'),
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
            'author.first_name as author_first_name',
            'author.last_name as author_last_name',
            'ip.ip as ip',
        ])
            ->leftJoin('ax_main_ips_has_resource as ev', static function ($join) use ($table) {
                $join->on('ev.resource_id', '=', $table . '.id')
                    ->where('ev.resource', '=', $table)
                    ->where('ev.event', '=', 'created');
            })
            ->leftJoin('ax_user as user', $this->table('user_id'), '=', 'user.id')
            ->leftJoin('ax_user as author', 'ev.user_id', '=', 'author.id')
            ->leftJoin('ax_main_ips as ip', 'ev.ips_id', '=', 'ip.id');
        return $this;
    }
}
