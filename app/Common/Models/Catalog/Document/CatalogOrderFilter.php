<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Main\QueryFilter;
use App\Common\Models\User\User;

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
            'd.title as delivery_title',
            'p.title as payment_title',
            'address.index as address_index',
            'address.region as address_region',
            'address.city as address_city',
            'address.street as address_street',
            'address.house as address_house',
            'address.apartment as address_apartment',
            'coupon.value as coupon_value',
            'coupon.discount as coupon_discount',
        ])
            ->leftJoin('ax_user as user', $this->table('user_id'), '=', 'user.id')
            ->leftJoin('ax_main_events as ev', static function ($join) use ($table) {
                $join->on('ev.resource_id', '=', $table . '.id')
                    ->where('ev.resource', '=', $table)
                    ->where('ev.event', '=', 'created');
            })
            ->leftJoin('ax_main_ips as ip', 'ev.ips_id', '=', 'ip.id')
            ->leftJoin('ax_user as author', 'ev.user_id', '=', 'author.id')
            ->leftJoin('ax_main_address as address', static function ($join) use ($table) {
                $join->on('address.resource_id', '=', 'user.id')
                    ->where('address.resource', '=', 'ax_user')
                    ->where('address.is_delivery', 1);
            })
            ->leftJoin('ax_catalog_delivery_type as d', $this->table('catalog_delivery_type_id'), '=', 'd.id')
            ->leftJoin('ax_catalog_payment_type as p', $this->table('catalog_payment_type_id'), '=', 'p.id')
            ->leftJoin('ax_catalog_coupon as coupon', $this->table('catalog_coupon_id'), '=', 'coupon.id');
        return $this;
    }
}
