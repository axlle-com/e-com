<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%catalog_property_has_resource}}".
 *
 * @property int             $property_id
 * @property int             $resource_id
 * @property string          $resource
 *
 * @property CatalogProperty $property
 */
class CatalogPropertyHasResource extends BaseModel
{
    protected $table = 'ax_catalog_property_has_resource';
}
