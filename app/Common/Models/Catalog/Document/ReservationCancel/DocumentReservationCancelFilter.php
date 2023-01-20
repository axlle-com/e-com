<?php

namespace App\Common\Models\Catalog\Document\ReservationCancel;

use App\Common\Models\Main\QueryFilter;

class DocumentReservationCancelFilter extends QueryFilter
{
    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([
            $this->table('*'),
            'fin.name as fin_name',
            'fin.title as fin_title',
            'storage_place.title as storage_place_title',
        ])
                      ->leftJoin('ax_fin_transaction_type as fin', $this->table('fin_transaction_type_id'), '=', 'fin.id')
                      ->leftJoin('ax_catalog_storage_place as storage_place', $this->table('catalog_storage_place_id'), '=', 'storage_place.id')
                      ->with(['contents'])
                      ->joinHistory();
        return $this;
    }
}
