<?php

namespace App\Common\Models\Catalog\Document\WriteOff;

use App\Common\Models\Main\QueryFilter;

class DocumentWriteOffFilter extends QueryFilter
{
    public function _filter(): static
    {
        $table = $this->table();
        $this->builder->select([
            $this->table('*'),
            'storage_place.title as storage_place_title',
        ])
                      ->leftJoin('ax_catalog_storage_place as storage_place', $this->table('catalog_storage_place_id'), '=', 'storage_place.id')
                      ->with(['contents'])
                      ->joinHistory();
        return $this;
    }
}
