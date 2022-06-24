<?php

namespace App\Common\Models\Catalog\Storage;

use App\Common\Models\Catalog\Document\Main\Document;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%ax_catalog_storage_reserve}}".
 *
 * @property int $id
 * @property int $catalog_storage_place_id
 * @property int $catalog_product_id
 * @property int $document_id
 * @property string $document
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

    public static function createOrUpdate(Document $content): self
    {
        if (!empty($content->subject)) {
            if (in_array($content->subject, ['reservation', 'order'])) {
                $model = new self;
                $model->catalog_storage_place_id = CatalogStoragePlace::query()->first()->id ?? null;
                $model->catalog_product_id = $content->catalog_product_id;
                $model->document_id = $content->document_id;
                $model->document = $content->document;
                $model->in_reserve += $content->quantity;
                $model->expired_at = time() + (60 * 15);
                return $model->safe();
            }
            if ($content->subject === 'reservation_cancel') {
                $id = $content->document->document_id_target ?? null;
                $model = $content->document->document ?? null;
                if ($id && $model) {
                    /* @var $model self */
                    $model = self::query()
                        ->where('document_id', $id)
                        ->where('document', $model)
                        ->where('catalog_product_id', $content->catalog_product_id)
                        ->first();
                    if ($model) {
                        $model->in_reserve -= $content->quantity;
                        if ($model->in_reserve >= 0) {
                            return $model->safe();
                        }
                        return $model->setErrors(['storage' => 'Остаток не может быть меньше нуля!']);
                    }
                }
                $products = self::query()
                    ->where('catalog_product_id', $content->catalog_product_id)
                    ->where('in_reserve', '>', 0)
                    ->orderBy('expired_at')
                    ->get();
                if (count($products)) {
                    $error = [];
                    $cnt = $content->quantity;
                    /* @var $item self */
                    foreach ($products as $item) {
                        $cnt -= $item->in_reserve;
                        if ($cnt <= 0) {
                            $item->in_reserve -= $content->quantity;
                            if (!$item->in_reserve) {
                                $item->expired_at = null;
                            }
                            if ($err = $item->safe()->getErrors()) {
                                $error[] = $err;
                            }
                            break;
                        }
                        $item->in_reserve = 0;
                        if ($err = $item->safe()->getErrors()) {
                            $error[] = $err;
                        }
                    }
                    if ($error) {
                        return (new self())->setErrors(['storage' => $error]);
                    }
                    if ($cnt > 0) {
                        return (new self())->setErrors(['storage' => 'Нет нужного количества']);
                    }
                    return (new self());
                }
                return (new self())->setErrors(['storage' => 'Не указано основание']);
            }
        }
        return (new self())->setErrors(['storage' => 'Не указан тип операции']);
    }
}
