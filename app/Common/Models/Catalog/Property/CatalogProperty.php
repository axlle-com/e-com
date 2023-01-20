<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "ax_catalog_property".
 *
 * @property int $id
 * @property int $catalog_property_type_id
 * @property int|null $catalog_property_unit_id
 * @property string $title
 * @property string|null $description
 * @property int|null $sort
 * @property string|null $image
 * @property int|null $is_hidden
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property string|null $type_resource
 * @property string|null $type_title
 * @property string|null $unit_title
 *
 * @property CatalogProductHasValueDecimal[] $catalogProductHasValueDecimals
 * @property CatalogProductHasValueInt[] $catalogProductHasValueInts
 * @property CatalogProductHasValueText[] $catalogProductHasValueTexts
 * @property CatalogProductHasValueVarchar[] $catalogProductHasValueVarchars
 * @property CatalogPropertyType $propertyType
 * @property CatalogPropertyGroup[] $catalogPropertyGroups
 * @property CatalogPropertyUnit $unit
 */
class CatalogProperty extends BaseModel
{
    protected $table = 'ax_catalog_property';

    public static function withType(): Builder
    {
        return self::query()->select([
            'ax_catalog_property.*',
            't.title as type_title',
            't.resource as type_resource',
        ])->join('ax_catalog_property_type as t', 't.id', '=', 'ax_catalog_property.catalog_property_type_id');
    }

    public static function setValue(array $property): bool
    {
        $propertyId = $property['property_id'] ?? null;
        $catalogProductId = $property['catalog_product_id'] ?? null;
        if ($propertyId && $model = self::filter()->find($propertyId)) {
            $type = array_flip(CatalogPropertyType::$types)[$model->type_resource];
            # TODO Реализовать красиво
            if ($type === 'int') {
                $property['property_value'] = (int)$property['property_value'];
            } else {
                if ($type === 'double') {
                    $property['property_value'] = (double)$property['property_value'];
                } else {
                    if ($type === 'varchar') {
                        $property['property_value'] = mb_substr($property['property_value'], 0, 499);
                    }
                }
            }
            $insert = $update = false;
            $select = DB::table($model->type_resource)
                        ->where('catalog_product_id', $catalogProductId)
                        ->where('catalog_property_id', $propertyId)
                        ->first();
            if (!$select && empty($property['property_value_id'])) {
                $insert = DB::table($model->type_resource)->insertGetId([
                    'catalog_product_id' => $catalogProductId,
                    'catalog_property_id' => $propertyId,
                    'catalog_property_unit_id' => $property['property_unit_id'],
                    'value' => $property['property_value'],
                    'sort' => $property['property_value_sort'],
                    'created_at' => time(),
                    'updated_at' => time(),
                ]);
            } else {
                $update = DB::table($model->type_resource)
                            ->where('catalog_product_id', $catalogProductId)
                            ->where('catalog_property_id', $propertyId)
                            ->update([
                                'catalog_property_unit_id' => $property['property_unit_id'],
                                'value' => $property['property_value'],
                                'sort' => $property['property_value_sort'],
                                'updated_at' => time(),
                            ]);
            }
            return $insert || $update;
        }
        return false;
    }

    public static function createOrUpdate(array $post): self
    {
        if (empty($post['property_id']) || !$model = self::query()->find($post['property_id'])) {
            $model = new self();
        }
        $model->title = $post['property_title'];
        $model->is_hidden = isset($post['is_hidden']) ? 1 : 0;
        $model->catalog_property_type_id = $post['catalog_property_type_id'];
        $model->catalog_property_unit_id = $post['catalog_property_unit_id'] ?? null;
        return $model->safe();
    }

    public static function deleteById(int $id): self
    {
        $self = new self();
        if ($property = self::query()->find($id)) {
            $arr = [];
            foreach (CatalogPropertyType::$types as $type => $table) {
                $arr[$type] = DB::table($table . ' as ' . $type)
                                ->select([
                                    $type . '.id as property_value_id',
                                    $type . '.value as property_value',
                                    $type . '.sort as property_value_sort',
                                    $type . '.catalog_product_id as catalog_product_id',
                                    $type . '.catalog_property_id as property_id',
                                    $type . '.catalog_property_unit_id as property_unit_id',
                                    'prop.title as property_title',
                                    'type.title as type_title',
                                    'type.resource as type_resource',
                                    'unit.title as unit_title',
                                    'unit.national_symbol as unit_symbol',
                                ])
                                ->join('ax_catalog_property as prop', 'prop.id', '=', $type . '.catalog_property_id')
                                ->join('ax_catalog_property_type as type', 'type.id', '=', 'prop.catalog_property_type_id')
                                ->leftJoin('ax_catalog_property_unit as unit', 'unit.id', '=', $type . '.catalog_property_unit_id')
                                ->where('prop.id', $id);
            }
            $all = $arr['text']->union($arr['int'])
                               ->union($arr['double'])
                               ->union($arr['varchar'])
                               ->orderBy('property_value_sort')
                               ->get();
            if (count($all)) {
                return $self->setErrors(_Errors::error('Свойство используется. Удаление не возможно.', $self));
            }
            $property->delete();
            return $self;
        }
        return $self->setErrors(_Errors::error('Свойство не найдено', $self));
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(CatalogPropertyType::class, 'catalog_property_type_id', 'id');
    }

    public function catalogPropertyValues(): HasMany
    {
        return $this->hasMany(CatalogPropertyValue::class, 'property_id', 'id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(CatalogPropertyUnit::class, 'catalog_property_unit_id', 'id');
    }

}
