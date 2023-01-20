<?php

namespace App\Common\Models\Catalog\Product;

use App\Common\Console\Commands\Currency;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%catalog_product_has_currency}}".
 *
 * @property int $catalog_product_id
 * @property int $currency_id
 * @property float $amount
 * @property int $date_rate
 *
 * @property CatalogProduct $catalogProduct
 * @property Currency $currency
 */
class CatalogProductHasCurrency extends BaseModel
{
    protected $table = 'ax_catalog_product_has_currency';
}
