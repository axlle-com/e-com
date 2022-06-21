<?php

namespace App\Common\Models\Catalog\Document\Main;

use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\Status;

/**
 * This is the model class for storage.
 *
 * @property int $id
 * @property int $document_id
 * @property int $catalog_product_id
 * @property int $catalog_storage_id
 * @property int|null $price
 * @property int $quantity
 *
 * @property string|null $product_title
 *
 * @property CatalogStoragePlace $catalogStoragePlace
 * @property DocumentBase $document
 * @property CatalogProduct $catalogProduct
 */
class DocumentContentBase extends BaseModel
{
    public ?DocumentBase $documentClass;

    public static function documentTable(string $column = '')
    {
        $string = substr(static::class, -7);
        $column = $column ? '.' . trim($column, '.') : '';
        return (new $string())->getTable($column);
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['document_content_id']) || !$model = self::query()->find($post['document_content_id'])) {
            $model = new static;
            $model->document_id = $post['document_id'] ?? $post['catalog_document_id']; # TODO: remake
        }
        $model->price = $post['price'] ?? $post['price_out'] ?? 0.0; # TODO: remake
        $model->quantity = $post['quantity'] ?? 1;
        $model->catalog_product_id = $post['catalog_product_id'];
        $model->created_at = $post['created_at'] ?? time();
        $model->updated_at = $post['updated_at'] ?? time();
        return $model->safe();
    }

    public function posting(): static
    {
        $storage = CatalogStorage::createOrUpdate(new Document($this));
        if ($errors = $storage->getErrors()) {
            return $this->setErrors($errors);
        }
        if (!empty($storage->id)) {
            $this->catalog_storage_id = $storage->id;
            if ($err = CatalogProduct::postingById($this->catalog_product_id)->getErrors()) {
                return $this->setErrors($err);
            }
            return $this->safe();
        }
        return $this->setErrors(['catalog_storage_id' => 'Должна быть принадлежность к складу']);
    }

    public static function deleteContent(int $id): bool
    {
        $model = static::query()
            ->select([static::table('*')])
            ->join(static::documentTable(), static function ($join) {
                $join->on(static::documentTable('id'), '=', static::table('document_id'))
                    ->where(static::documentTable('status'), '!=', Status::STATUS_POST);
            })->find($id);
        return $model && $model->delete();
    }
}
