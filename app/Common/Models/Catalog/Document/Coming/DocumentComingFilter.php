<?php

namespace App\Common\Models\Catalog\Document\Coming;

use App\Common\Models\Main\QueryFilter;

class DocumentComingFilter extends QueryFilter
{
    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([
            $this->table('*'),
            'counterparty.name as counterparty_name',
            'individual.last_name as individual_name',
            'storage_place.title as storage_place_title',
        ])
            ->leftJoin('ax_counterparty as counterparty', $this->table('counterparty_id'), '=', 'counterparty.id')
            ->leftJoin('ax_user as individual', 'counterparty.user_id', '=', 'individual.id')
            ->leftJoin('ax_catalog_storage_place as storage_place', $this->table('catalog_storage_place_id'), '=', 'storage_place.id')
            ->with(['contents'])
            ->joinHistory();
        return $this;
    }
}
