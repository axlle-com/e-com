<?php

namespace App\Common\Models\Catalog\Product;

use App\Common\Models\Main\QueryFilter;

class CatalogProductFilter extends QueryFilter
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
            'ax_catalog_product.*',
            'par.title as category_title',
            'par.title_short as category_title_short',
            'ren.title as render_title',
            'ren.name as render_name',
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
            'ip.ip as ip',
            'storage.price_in as price_in',
            'storage.price_out as price',
            'storage.in_stock as in_stock',
            'storage.in_reserve as in_reserve',
            'storage.reserve_expired_at as reserve_expired_at',
        ])
            ->leftJoin('ax_main_events as ev', static function ($join) use ($table) {
                $join->on('ev.resource_id', '=', $table . '.id')
                    ->where('ev.resource', '=', $table)
                    ->where('ev.event', '=', 'created');
            })
            ->leftJoin('ax_user as user', 'ev.user_id', '=', 'user.id')
            ->leftJoin('ax_main_ips as ip', 'ev.ips_id', '=', 'ip.id')
            ->leftJoin('ax_catalog_category as par', 'ax_catalog_product.category_id', '=', 'par.id')
            ->leftJoin('ax_catalog_storage as storage', 'storage.catalog_product_id', '=', $this->table('id'))
            ->leftJoin('ax_render as ren', 'ax_catalog_product.render_id', '=', 'ren.id');
        return $this;
    }

}
