<?php

namespace App\Common\Models\Catalog\Storage;

use App\Common\Models\Catalog\Document\CatalogDocumentContent;
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
 * @property CatalogProduct $catalogProduct
 * @property CatalogStoragePlace $catalogStoragePlace
 */
class CatalogStorage extends BaseModel
{
    private ?CatalogDocumentContent $document;
    protected $table = 'ax_catalog_storage';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function createOrUpdate(CatalogDocumentContent $document): self
    {
        $id = $document->catalog_storage_id ?? null;
        $model = self::query()
            ->when($id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->where('catalog_product_id', $document->catalog_product_id)
            ->where('catalog_storage_place_id', $document->document->catalog_storage_place_id)
            ->first();
        if (!$model) {
            $model = new self;
            $model->catalog_storage_place_id = $document->document->catalog_storage_place_id ?? CatalogStoragePlace::query()->first()->id ?? null;
            $model->catalog_product_id = $document->catalog_product_id;
        }
        if (!empty($document->subject)) {
            $method = Str::camel($document->subject);
            if (method_exists($model, $method)) {
                $model->document = $document;
                $model->{$method}();
            }
            if ($model->in_stock >= 0 && $model->in_reserve >= 0) {
                return $model->safe();
            }
        }
        return $model->setErrors(['storage' => 'Остаток не может быть меньше нуля!']);
    }

    public function refund(): self
    {
        $this->in_stock++;
        return $this;
    }

    public function coming(): self
    {
        $this->in_stock += $this->document->quantity;
        if (!empty($this->document->price_in)) {
            $this->price_in = $this->document->price_in;
        }
        $this->price_out = $this->document->price_out;
        return $this;
    }

    public function sale(): self
    {
        if ($this->document->catalog_document_id) {
            $this->document->subject = 'remove_reserve';
            $reserve = CatalogStorageReserve::createOrUpdate($this->document);
            if ($err = $reserve->getErrors()) {
                return $this->setErrors(['storage_reserve' => $err]);
            }
            $this->in_reserve -= $this->document->quantity;
            $reserve = CatalogStorageReserve::query()
                ->selectRaw('MIN(expired_at) AS expired_at')
                ->where('catalog_product_id', $this->document->catalog_product_id)
                ->where('in_reserve', '>', 0)
                ->first();
            $this->reserve_expired_at = $reserve ? $reserve->expired_at : null;
        } else {
            $this->in_stock -= $this->document->quantity;
            $this->price_out = $this->document->price_out;
        }
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

    public function invoice(): self
    {
        return $this->reservation();
    }

    public function removeReserve(): self
    {
        $reserve = CatalogStorageReserve::createOrUpdate($this->document);
        if ($err = $reserve->getErrors()) {
            return $this->setErrors(['storage_reserve' => $err]);
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
        $this->price_out = $this->document->price_out;
        return $this;
    }
}
