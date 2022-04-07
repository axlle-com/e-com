<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%catalog_storage}}".
 *
 * @property int $catalog_storage_place_id
 * @property int $catalog_product_id
 * @property int $quantity
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProduct $catalogProduct
 * @property CatalogStoragePlace $catalogStoragePlace
 */
class CatalogStorage extends BaseModel
{
    protected $table = 'ax_catalog_storage';

    public static function rules(string $type = 'create'): array
    {
    return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'catalog_storage_place_id' => 'Catalog Storage Place ID',
            'catalog_product_id' => 'Catalog Product ID',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogProduct()
    {
        return $this->hasOne(CatalogProduct::class, ['id' => 'catalog_product_id']);
    }

    public function getCatalogStoragePlace()
    {
        return $this->hasOne(CatalogStoragePlace::class, ['id' => 'catalog_storage_place_id']);
    }
}
