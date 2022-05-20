<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%catalog_storage}}".
 *
 * @property int $catalog_storage_place_id
 * @property int $catalog_product_id
 * @property int $in_stock
 * @property int|null $in_reserve
 * @property int|null $reserve_expired_at
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

    public static function createOrUpdate1(array $post): self
    {
        $id = $post['catalog_storage_id'] ?? null;
        $model = self::query()
            ->when($id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->where('catalog_product_id', $post['catalog_product_id'])
            ->first();
        if (!$model) {
            $model = new self;
            $model->catalog_storage_place_id = CatalogStoragePlace::query()->first()->id ?? null;
            $model->catalog_product_id = $post['catalog_product_id'];
        }
        if (!empty($post['subject'])) {
            if ($post['subject'] === 'coming') {
                $model->in_stock++;
            }
            if ($post['subject'] === 'sale') {
                $model->in_stock--;
            }
            if ($post['subject'] === 'reserve') {
                $model->in_stock--;
                $model->in_reserve++;
                $model->reserve_expired_at = time() + (60 * 15);
            }
            if ($post['subject'] === 'de_reserve') {
                $model->in_stock++;
                $model->in_reserve--;
                $model->reserve_expired_at = null;
            }
        }
        return $model->safe();
    }

    public static function createOrUpdate(CatalogDocumentContent $content): self
    {
        $id = $content->catalog_storage_id ?? null;
        $model = self::query()
            ->when($id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->where('catalog_product_id', $content->catalog_product_id)
            ->first();
        if (!$model) {
            $model = new self;
            $model->catalog_storage_place_id = CatalogStoragePlace::query()->first()->id ?? null;
            $model->catalog_product_id = $content->catalog_product_id;
        }
        if (!empty($content->subject)) {
            if ($content->subject === 'coming') {
                $model->in_stock++;
            }
            if ($content->subject === 'sale') {
                $model->in_stock--;
            }
            if ($content->subject === 'reserve') {
                $model->in_stock--;
                $model->in_reserve++;
                $model->reserve_expired_at = time() + (60 * 15);
            }
            if ($content->subject === 'de_reserve') {
                $model->in_stock++;
                $model->in_reserve--;
                $model->reserve_expired_at = null;
            }
            if ($content->subject === 'write_off') {
                $model->in_stock--;
            }
            if ($model->in_stock >= 0 && $model->in_reserve >= 0) {
                return $model->safe();
            }
        }
        return $model->setErrors(['storage' => 'Остаток не может быть меньше нуля!']);
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
