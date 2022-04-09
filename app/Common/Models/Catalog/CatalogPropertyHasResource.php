<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%catalog_property_has_resource}}".
 *
 * @property int $property_id
 * @property int $resource_id
 * @property string $resource
 *
 * @property CatalogProperty $property
 */
class CatalogPropertyHasResource extends BaseModel
{
    protected $table = 'ax_catalog_property_has_resource';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'property_id' => 'Property ID',
            'resource_id' => 'Resource ID',
            'resource' => 'Resource',
        ];
    }

    public function getProperty()
    {
        return $this->hasOne(CatalogProperty::class, ['id' => 'property_id']);
    }
}
