<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_catalog_property_type".
 *
 * @property int $id
 * @property string $resource Таблица в которой лежит value
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
class CatalogPropertyType extends BaseModel
{
    protected $table = 'ax_catalog_property_type';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resource' => 'Таблица в которой лежит value',
            'title' => 'Title',
            'description' => 'Description',
            'sort' => 'Sort',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }


    public function getCatalogProductHasValueDecimals()
    {
        return $this->hasMany(CatalogProductHasValueDecimal::className(), ['catalog_property_id' => 'id']);
    }

    public function getCatalogProductHasValueInts()
    {
        return $this->hasMany(CatalogProductHasValueInt::className(), ['catalog_property_id' => 'id']);
    }

    public function getCatalogProductHasValueTexts()
    {
        return $this->hasMany(CatalogProductHasValueText::className(), ['catalog_property_id' => 'id']);
    }

    public function getCatalogProductHasValueVarchars()
    {
        return $this->hasMany(CatalogProductHasValueVarchar::className(), ['catalog_property_id' => 'id']);
    }

    public function getCatalogPropertyGroup()
    {
        return $this->hasOne(CatalogPropertyGroup::className(), ['id' => 'catalog_property_group_id']);
    }

    public function getCatalogPropertyType()
    {
        return $this->hasOne(CatalogPropertyType::className(), ['id' => 'catalog_property_type_id']);
    }

    public function getCatalogPropertyUnits()
    {
        return $this->hasMany(CatalogPropertyUnit::className(), ['catalog_property_id' => 'id']);
    }
}
