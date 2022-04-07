<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%catalog_storage_place}}".
 *
 * @property int $id
 * @property int|null $catalog_storage_place_id
 * @property int $is_place
 * @property string $title
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogDocumentContent[] $catalogDocumentContents
 * @property CatalogStorage[] $catalogStorages
 * @property CatalogProduct[] $catalogProducts
 * @property CatalogStoragePlace $catalogStoragePlace
 * @property CatalogStoragePlace[] $catalogStoragePlaces
 */
class CatalogStoragePlace extends BaseModel
{
    protected $table = ';catalog_storage_place';

    public static function rules(string $type = 'create'): array
    {
    return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_storage_place_id' => 'Catalog Storage Place ID',
            'is_place' => 'Is Place',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogDocumentContents()
    {
        return $this->hasMany(CatalogDocumentContent::class, ['catalog_storage_place_id' => 'id']);
    }

    public function getCatalogStorages()
    {
        return $this->hasMany(CatalogStorage::class, ['catalog_storage_place_id' => 'id']);
    }

    public function getCatalogProducts()
    {
        return $this->hasMany(CatalogProduct::class, ['id' => 'catalog_product_id'])->viaTable('{{%catalog_storage}}', ['catalog_storage_place_id' => 'id']);
    }

    public function getCatalogStoragePlace()
    {
        return $this->hasOne(CatalogStoragePlace::class, ['id' => 'catalog_storage_place_id']);
    }

    public function getCatalogStoragePlaces()
    {
        return $this->hasMany(CatalogStoragePlace::class, ['catalog_storage_place_id' => 'id']);
    }
}
