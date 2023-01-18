<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Collection;

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
 * @property Collection<CatalogProperty> $catalogProperties
 */
class CatalogPropertyType extends BaseModel
{
    protected $table = 'ax_catalog_property_type';

    public static array $types = [
        'int' => 'ax_catalog_product_has_value_int',
        'double' => 'ax_catalog_product_has_value_decimal',
        'varchar' => 'ax_catalog_product_has_value_varchar',
        'text' => 'ax_catalog_product_has_value_text',
    ];
}
