<?php

namespace App\Common\Models\Catalog\Storage;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Document\CatalogDocumentContent;

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
    protected $table = 'ax_catalog_storage_place';

}
