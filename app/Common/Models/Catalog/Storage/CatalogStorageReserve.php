<?php

namespace App\Common\Models\Catalog\Storage;

use App\Common\Models\Catalog\Document\CatalogDocumentContent;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%ax_catalog_storage_reserve}}".
 *
 * @property int $id
 * @property int $catalog_storage_place_id
 * @property int $catalog_product_id
 * @property string $resource
 * @property int $resource_id
 * @property int|null $status
 * @property int|null $in_reserve
 * @property int|null $expired_at
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProduct $catalogProduct
 */
class CatalogStorageReserve extends BaseModel
{
    protected $table = 'ax_catalog_storage_reserve';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function createOrUpdate(CatalogDocumentContent $content): self
    {
        $id = $content->catalog_storage_id ?? null;
        $model = self::query()
            ->when($id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->where('catalog_product_id', $content->catalog_product_id)
            ->where('catalog_document_id', $content->catalog_document_id)
            ->first();
        if (!$model) {
            $model = new self;
            $model->catalog_storage_place_id = CatalogStoragePlace::query()->first()->id ?? null;
            $model->catalog_product_id = $content->catalog_product_id;
        }
        if (!empty($content->subject)) {
            if ($content->subject === 'reservation') {
                $model->in_reserve += $content->quantity;
                $model->expired_at = time() + (60 * 15);
            }
            if ($content->subject === 'remove_reserve') {
                $model->in_reserve -= $content->quantity;
            }
            if ($model->in_reserve >= 0) {
                return $model->safe();
            }
        }
        return $model->setErrors(['storage' => 'Остаток не может быть меньше нуля!']);
    }
}
