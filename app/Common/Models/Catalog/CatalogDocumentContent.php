<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%catalog_document_content}}".
 *
 * @property int $id
 * @property int $catalog_document_id
 * @property int $catalog_product_id
 * @property int $catalog_storage_id
 * @property int $price
 * @property int $quantity
 *
 * @property CatalogStoragePlace $catalogStoragePlace
 * @property CatalogDocument $catalogDocument
 * @property CatalogProduct $catalogProduct
 */
class CatalogDocumentContent extends BaseModel
{
    protected $table = 'ax_catalog_document_content';

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

    public static function createOrUpdate(array $post)
    {
        if(empty($post['catalog_document_content_id']) || $model= self::query()->find($post['catalog_document_content_id'])){
            $model= new self;
            $model->catalog_document_id = $post['catalog_document_id'];
        }
        $model->price = $post['price'];
        $model->quantity = $post['quantity'];
        $model->catalog_product_id = $post['catalog_product_id'];
        $model->catalog_storage_id = CatalogStorage::createOrUpdate($post)->id ?? null;
        return $model->safe();
    }
}
