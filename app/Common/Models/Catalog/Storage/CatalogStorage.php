<?php

namespace App\Common\Models\Catalog\Storage;

use App\Common\Models\Catalog\Document\Main\Document;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\BaseModel;
use Illuminate\Support\Str;

/**
 * This is the model class for table "{{%catalog_storage}}".
 *
 * @property int $id
 * @property int $catalog_storage_place_id
 * @property int $catalog_product_id
 * @property int $in_stock
 * @property int|null $in_reserve
 * @property int|null $price_in
 * @property int|null $price_out
 * @property int|null $reserve_expired_at
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property string $product_title
 * @property string $storage_title
 *
 * @property CatalogProduct $catalogProduct
 * @property CatalogStoragePlace $catalogStoragePlace
 */
class CatalogStorage extends BaseModel
{
    private ?Document $document;
    protected $table = 'ax_catalog_storage';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function createOrUpdate(Document $document): self
    {
        $id = $document->catalog_storage_id ?? null;
        $model = self::query()
            ->when($id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->where('catalog_product_id', $document->catalog_product_id)
            ->where('catalog_storage_place_id', $document->catalog_storage_place_id)
            ->first();
        if (!$model) {
            $model = new self;
            $model->catalog_storage_place_id = $document->catalog_storage_place_id ?? CatalogStoragePlace::query()->first()->id ?? null;
            $model->catalog_product_id = $document->catalog_product_id;
        }
        if (!empty($document->subject)) {
            $method = Str::camel($document->subject);
            if (method_exists($model, $method)) {
                $model->document = $document;
                $model->{$method}();
            }
            if (!$model->getErrors() && $model->in_stock >= 0 && $model->in_reserve >= 0) {
                return $model->safe();
            }
            if ($err = $model->getErrors()) {
                $model->setErrors($err);
            }
            return $model->setErrors(['storage' => 'Остаток не может быть меньше нуля!']);
        }
        return $model->setErrors(['storage' => 'Не найдет идентификатор документа!']);
    }

    public function refund(): self
    {
        $this->in_stock++;
        return $this;
    }

    public function coming(): self
    {
        $this->in_stock += $this->document->quantity;
        if (!empty($this->document->price)) {
            $this->price_in = $this->document->price;
        }
        return $this;
    }

    public function sale(): self
    {
        if ($this->document->document_id_target) {
            $this->document->subject = 'reservation_cancel';
            $this->reservationCancel();
        }
        $this->in_stock -= $this->document->quantity;
        $this->price_out = $this->document->price;
        return $this;
    }

    public function reservation(): self
    {
        $reserve = CatalogStorageReserve::createOrUpdate($this->document);
        if ($err = $reserve->getErrors()) {
            return $this->setErrors(['storage_reserve' => $err]);
        }
        $this->in_stock -= $this->document->quantity;
        $this->in_reserve += $this->document->quantity;
        $reserve = CatalogStorageReserve::query()
            ->selectRaw('MIN(expired_at) AS expired_at')
            ->where('catalog_product_id', $this->document->catalog_product_id)
            ->where('in_reserve', '>', 0)
            ->first();
        $this->reserve_expired_at = $reserve ? $reserve->expired_at : null;
        return $this;
    }

    public function order(): self
    {
        return $this->reservation();
    }

    public function invoice(): self
    {
        return $this->reservation();
    }

    public function reservationCancel(): self
    {
        $reserve = CatalogStorageReserve::createOrUpdate($this->document);
        if ($err = $reserve->getErrors()) {
            return $this->setErrors($err);
        }

        $this->in_stock += $this->document->quantity;
        $this->in_reserve -= $this->document->quantity;
        $reserve = CatalogStorageReserve::query()
            ->selectRaw('MIN(expired_at) AS expired_at')
            ->where('catalog_product_id', $this->document->catalog_product_id)
            ->where('in_reserve', '>', 0)
            ->first();
        $this->reserve_expired_at = $reserve ? $reserve->expired_at : null;
        return $this;
    }

    public function writeOff(): self
    {
        $this->in_stock -= $this->document->quantity;
        $this->price_out = $this->document->price;
        return $this;
    }

    public function transfer(): self
    {
        $this->in_stock -= $this->document->quantity;
        if ($this->document->catalog_storage_place_id_target ?? null) {
            $model = self::query()
                ->where('catalog_product_id', $this->document->catalog_product_id)
                ->where('catalog_storage_place_id', $this->document->catalog_storage_place_id_target)
                ->first();
            if (!$model) {
                $model = new self;
                $model->catalog_storage_place_id = $this->document->catalog_storage_place_id_target ?? CatalogStoragePlace::query()->first()->id ?? null;
                $model->catalog_product_id = $this->document->catalog_product_id;
            }
            $model->in_stock += $this->document->quantity;
            if (!$model->getErrors() && $model->in_stock >= 0 && $model->in_reserve >= 0) {
                return $model->safe();
            }
            return $this->setErrors(['storage' => 'Остаток не может быть меньше нуля!']);
        }
        return $this;
    }
}
