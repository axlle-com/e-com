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
    private ?CatalogDocumentContent $content;
    protected $table = 'ax_catalog_storage';

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
            ->first();
        if (!$model) {
            $model = new self;
            $model->catalog_storage_place_id = CatalogStoragePlace::query()->first()->id ?? null;
            $model->catalog_product_id = $content->catalog_product_id;
        }
        if (!empty($content->subject)) {
            if ($model->in_reserve && $model->reserve_expired_at < time()) {
                $model->in_stock += $model->in_reserve;
                $model->in_reserve = 0;
                $model->reserve_expired_at = null;
            }
            $method = Str::camel($content->subject);
            if (method_exists($model, $method)) {
                $model->content = $content;
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
        $this->in_stock += $this->content->quantity;
        if (!empty($this->content->price_in)) {
            $this->price_in = $this->content->price_in;
        }
        $this->price_out = $this->content->price_out;
        return $this;
    }

    public function sale(): self
    {
        if ($this->content->catalog_document_content_id) {
            $this->content->subject = 'remove_reserve';
            $reserve = CatalogStorageReserve::createOrUpdate($this->content);
            if ($err = $reserve->getErrors()) {
                return $this->setErrors(['storage_reserve' => $err]);
            }
            $this->in_reserve -= $this->content->quantity;
            $reserve = CatalogStorageReserve::query()
                ->selectRaw('MIN(expired_at) AS expired_at')
                ->where('catalog_product_id', $this->content->catalog_product_id)
                ->where('in_reserve', '>', 0)
                ->first();
            $this->reserve_expired_at = $reserve ? $reserve->expired_at : null;
        } else {
            $this->in_stock -= $this->content->quantity;
            $this->price_out = $this->content->price_out;
        }
        return $this;
    }

    public function reservation(): self
    {
        $reserve = CatalogStorageReserve::createOrUpdate($this->content);
        if ($err = $reserve->getErrors()) {
            return $this->setErrors(['storage_reserve' => $err]);
        }
        $this->in_stock -= $this->content->quantity;
        $this->in_reserve += $this->content->quantity;
        $reserve = CatalogStorageReserve::query()
            ->selectRaw('MIN(expired_at) AS expired_at')
            ->where('catalog_product_id', $this->content->catalog_product_id)
            ->where('in_reserve', '>', 0)
            ->first();
        $this->reserve_expired_at = $reserve ? $reserve->expired_at : null;
        return $this;
    }

    public function removeReserve(): self
    {
        $reserve = CatalogStorageReserve::createOrUpdate($this->content);
        if ($err = $reserve->getErrors()) {
            return $this->setErrors(['storage_reserve' => $err]);
        }
        $this->in_stock += $this->content->quantity;
        $this->in_reserve -= $this->content->quantity;
        $reserve = CatalogStorageReserve::query()
            ->selectRaw('MIN(expired_at) AS expired_at')
            ->where('catalog_product_id', $this->content->catalog_product_id)
            ->where('in_reserve', '>', 0)
            ->first();
        $this->reserve_expired_at = $reserve ? $reserve->expired_at : null;
        return $this;
    }

    public function writeOff(): self
    {
        $this->in_stock -= $this->content->quantity;
        $this->price_out = $this->content->price_out;
        return $this;
    }
}
