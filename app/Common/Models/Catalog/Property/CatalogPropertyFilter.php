<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Main\QueryFilter;

class CatalogPropertyFilter extends QueryFilter
{
    protected array $safeFields = [
    ];

    public function _filter(): static
    {
        $this->builder->select([
            $this->table . '.*',
            'type.resource as type_resource',
        ])
            ->join('ax_catalog_property_type as type', $this->table . '.catalog_property_type_id', '=', 'type.id');
        return $this;
    }

}
