<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Main\QueryFilter;

class DocumentOrderFilter extends QueryFilter
{
    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([
            $this->table('*'),
            'individual.last_name as individual_name',
            'individual.first_name as individual_first_name',
            'individual.patronymic as individual_patronymic',
            'individual.phone as individual_phone',
            'individual.email as individual_email',
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
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
            'fin.name as fin_name',
            'fin.title as fin_title',
            'ip.ip as ip',
            'ds.title as delivery_status',
            'ax_catalog_payment_status.title as payment_status',
            'storage_place.title as storage_place_title',
        ])
            ->leftJoin('ax_counterparty as counterparty', $this->table('counterparty_id'), '=', 'counterparty.id')
            ->leftJoin('ax_user as individual', 'counterparty.user_id', '=', 'individual.id')
            ->leftJoin('ax_main_events as ev', static function ($join) use ($table) {
                $join->on('ev.resource_id', '=', $table . '.id')
                    ->where('ev.resource', '=', $table)
                    ->where('ev.event', '=', 'created');
            })
            ->leftJoin('ax_main_ips as ip', 'ev.ips_id', '=', 'ip.id')
            ->leftJoin('ax_user as user', 'ev.user_id', '=', 'user.id')
            ->leftJoin('ax_main_address as address', static function ($join) use ($table) {
                $join->on('address.resource_id', '=', 'individual.id')
                    ->where('address.resource', '=', 'ax_user')
                    ->where('address.is_delivery', 1);
            })
            ->leftJoin('ax_catalog_delivery_type as d', $this->table('catalog_delivery_type_id'), '=', 'd.id')
            ->leftJoin('ax_catalog_payment_type as p', $this->table('catalog_payment_type_id'), '=', 'p.id')
            ->leftJoin('ax_catalog_coupon as coupon', $this->table('catalog_coupon_id'), '=', 'coupon.id')
            ->leftJoin('ax_fin_transaction_type as fin', $this->table('fin_transaction_type_id'), '=', 'fin.id')
            ->leftJoin('ax_catalog_delivery_status as ds', $this->table('catalog_delivery_status_id'), '=', 'ds.id')
            ->leftJoin('ax_catalog_payment_status', $this->table('catalog_payment_status_id'), '=', 'ax_catalog_payment_status.id')
            ->leftJoin('ax_catalog_storage_place as storage_place', $this->table('catalog_storage_place_id'), '=', 'storage_place.id');
        return $this;
    }
}
