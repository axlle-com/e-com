<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;

/**
* This is the model class for table "ax_catalog_property_group".
*
* @property int $id
* @property string $title
* @property string|null $description
* @property int|null $sort
* @property string|null $image
* @property int|null $created_at
* @property int|null $updated_at
* @property int|null $deleted_at
*
* @property CatalogProperty[] $catalogProperties
*/
class CatalogPropertyGroup extends BaseModel
{
    protected $table = 'ax_catalog_property_group';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
                    'id' => 'ID',
                    'title' => 'Title',
                    'description' => 'Description',
                    'sort' => 'Sort',
                    'image' => 'Image',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                    'deleted_at' => 'Deleted At',
                ];
    }

    public function getCatalogProperties()
    {
    return $this->hasMany(CatalogProperty::class, ['catalog_property_group_id' => 'id']);
    }
}
