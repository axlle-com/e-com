<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "ax_catalog_property".
 *
 * @property int $id
 * @property int $catalog_property_type_id
 * @property string $title
 * @property string|null $description
 * @property int|null $sort
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property string|null $type_resource
 *
 * @property CatalogProductHasValueDecimal[] $catalogProductHasValueDecimals
 * @property CatalogProductHasValueInt[] $catalogProductHasValueInts
 * @property CatalogProductHasValueText[] $catalogProductHasValueTexts
 * @property CatalogProductHasValueVarchar[] $catalogProductHasValueVarchars
 * @property CatalogPropertyType $propertyType
 * @property CatalogPropertyGroup[] $catalogPropertyGroups
 * @property CatalogPropertyUnit[] $units
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

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(CatalogPropertyType::class, 'catalog_property_type_id', 'id');
    }

    public function catalogPropertyValues(): HasMany
    {
        return $this->hasMany(CatalogPropertyValue::class, 'property_id', 'id');
    }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(
            CatalogPropertyUnit::class,
            'ax_catalog_property_has_unit',
            'catalog_property_id',
            'catalog_property_unit_id'
        );
    }

    public static function setValue(array $property): bool
    {
        $propertyId = $property['property_id'] ?? null;
        $catalogProductId = $property['catalog_product_id'] ?? null;
        if ($propertyId && $model = self::filter()->find($propertyId)) {
            $insert = $update = false;
            $select = DB::table($model->type_resource)
                ->where('catalog_product_id', $catalogProductId)
                ->where('catalog_property_id', $propertyId)
                ->first();
            if (!$select && empty($property['property_value_id'])) {
                $insert = DB::table($model->type_resource)->insertGetId(
                    [
                        'catalog_product_id' => $catalogProductId,
                        'catalog_property_id' => $propertyId,
                        'catalog_property_unit_id' => $property['property_unit_id'],
                        'value' => $property['property_value'],
                        'sort' => $property['property_value_sort'],
                        'created_at' => time(),
                        'updated_at' => time(),
                    ]
                );
            } else {
                $update = DB::table($model->type_resource)
                    ->where('catalog_product_id', $catalogProductId)
                    ->where('catalog_property_id', $propertyId)
                    ->update([
                        'value' => $property['property_value'],
                        'sort' => $property['property_value_sort'],
                        'catalog_property_unit_id' => $property['property_unit_id'],
                        'updated_at' => time(),
                    ]);
            }
            return $insert || $update;
        }
        return false;
    }
}
