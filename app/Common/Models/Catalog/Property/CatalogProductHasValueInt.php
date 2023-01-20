<?php

namespace App\Common\Models\Catalog\Property;

use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_catalog_product_has_value_int".
 *
 * @property int $id
 * @property int $catalog_product_id
 * @property int $catalog_property_id
 * @property int|null $catalog_property_unit_id
 * @property int $value
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProduct $catalogProduct
 * @property CatalogProperty $catalogProperty
 * @property CatalogPropertyUnit $catalogPropertyUnit
 */
class CatalogProductHasValueInt extends BaseModel
{
    protected $table = 'ax_catalog_product_has_value_int';
}
