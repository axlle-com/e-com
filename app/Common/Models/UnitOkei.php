<?php

namespace App\Common\Models;

use App\Common\Models\Catalog\CatalogPropertyUnit;

/**
 * This is the model class for table "ax_unit_okei".
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string|null $national_symbol
 * @property string|null $national_code
 * @property string|null $international_symbol
 * @property string|null $international_code
 * @property string|null $description
 * @property int|null $sort
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogPropertyUnit[] $catalogPropertyUnits
 */
class UnitOkei extends BaseModel
{
    protected $table = 'ax_unit_okei';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
            'national_symbol' => 'National Symbol',
            'national_code' => 'National Code',
            'international_symbol' => 'International Symbol',
            'international_code' => 'International Code',
            'description' => 'Description',
            'sort' => 'Sort',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogPropertyUnits()
    {
        return $this->hasMany(CatalogPropertyUnit::className(), ['unit_okei_id' => 'id']);
    }
}
