<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Main\QueryFilter;

class CatalogPropertyFilter extends QueryFilter
{
    protected array $safeFields = [];

    public function _filter(): static
    {
        $this->builder->select([
            $this->table . '.*',
            CatalogPropertyUnit::table('title') . ' as unit_title',
            'type.title as type_title',
            'type.resource as type_resource',
        ])
                      ->leftJoin(CatalogPropertyUnit::table(), $this->table . '.catalog_property_unit_id', '=', CatalogPropertyUnit::table('id'))
                      ->leftJoin('ax_catalog_property_type as type', $this->table . '.catalog_property_type_id', '=', 'type.id');
        return $this;
    }

}
