<?php

namespace App\Common\Models\Catalog\Document\Reservation;

use App\Common\Models\Main\QueryFilter;

class DocumentReservationFilter extends QueryFilter
{
    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([
            $this->table('*'),
            'user.first_name as user_first_name',
            'user.last_name as user_last_name',
            'ip.ip as ip',
            'fin.name as fin_name',
            'fin.title as fin_title',
            'counterparty.name as counterparty_name',
            'individual.last_name as individual_name',
            'storage_place.title as storage_place_title',
        ])
            ->leftJoin('ax_main_events as ev', static function ($join) use ($table) {
                $join->on('ev.resource_id', '=', $table . '.id')
                    ->where('ev.resource', '=', $table)
                    ->where('ev.event', '=', 'created');
            })
            ->leftJoin('ax_user as user', 'ev.user_id', '=', 'user.id')
            ->leftJoin('ax_main_ips as ip', 'ev.ips_id', '=', 'ip.id')
            ->leftJoin('ax_fin_transaction_type as fin', $this->table('fin_transaction_type_id'), '=', 'fin.id')
            ->leftJoin('ax_counterparty as counterparty', $this->table('counterparty_id'), '=', 'counterparty.id')
            ->leftJoin('ax_user as individual', 'counterparty.user_id', '=', 'individual.id')
            ->leftJoin('ax_catalog_storage_place as storage_place', $this->table('catalog_storage_place_id'), '=', 'storage_place.id')
            ->with(['contents']);
        return $this;
    }
}
