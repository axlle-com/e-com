<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "ax_catalog_property".
 *
 * @property int $id
 * @property int|null $catalog_property_group_id
 * @property string $title
 * @property string|null $description
 * @property int|null $sort
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogPropertyHasResource[] $catalogPropertyHasResources
 * @property CatalogPropertyUnit[] $catalogPropertyUnits
 * @property CatalogPropertyValue[] $catalogPropertyValues
 */
class CatalogProperty extends BaseModel
{
    protected $table = 'ax_catalog_property';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function catalogPropertyValues(): HasMany
    {
        return $this->hasMany(CatalogPropertyValue::class, 'property_id', 'id');
    }

    public function catalogPropertyUnits(): HasMany
    {
        return $this->hasMany(CatalogPropertyUnit::class, 'catalog_property_id', 'id');
    }
}
