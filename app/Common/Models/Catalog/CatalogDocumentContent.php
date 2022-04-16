<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%catalog_document_content}}".
 *
 * @property int $id
 * @property int $catalog_document_id
 * @property int $catalog_product_id
 * @property int|null $catalog_storage_place_id
 *
 * @property CatalogStoragePlace $catalogStoragePlace
 * @property CatalogDocument $catalogDocument
 * @property CatalogProduct $catalogProduct
 */
class CatalogDocumentContent extends BaseModel
{
    protected $table = ';catalog_document_content';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_document_id' => 'Catalog Document ID',
            'catalog_product_id' => 'Catalog Product ID',
            'catalog_storage_place_id' => 'Catalog Storage Place ID',
        ];
    }

    public function getCatalogStoragePlace()
    {
        return $this->hasOne(CatalogStoragePlace::class, ['id' => 'catalog_storage_place_id']);
    }

    public function getCatalogDocument()
    {
        return $this->hasOne(CatalogDocument::class, ['id' => 'catalog_document_id']);
    }

    public function getCatalogProduct()
    {
        return $this->hasOne(CatalogProduct::class, ['id' => 'catalog_product_id']);
    }
}
