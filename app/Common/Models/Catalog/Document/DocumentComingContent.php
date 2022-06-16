<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%ax_document_coming_content}}".
 *
 * @property int $id
 * @property int $catalog_document_id
 * @property int $catalog_product_id
 * @property int $catalog_storage_id
 * @property int|null $price_in
 * @property int|null $price_out
 * @property int $quantity
 *
 * @property string $subject
 * @property int|null $incoming_document_id
 * @property string|null $product_title
 *
 * @property CatalogStoragePlace $catalogStoragePlace
 * @property CatalogDocument $document
 * @property CatalogProduct $catalogProduct
 */
class DocumentComingContent extends BaseModel
{
    use EventSetter;

    public string $subject = '';
    public ?int $incoming_document_id = null;
    protected $table = 'ax_document_coming_content';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function createOrUpdate(array $post): self
    {
        if (empty($post['catalog_document_content_id']) || !$model = self::query()->find($post['catalog_document_content_id'])) {
            $model = new self;
            $model->catalog_document_id = $post['catalog_document_id'];
        }
        $model->price_out = $post['price_out'] ?? 0.0;
        $model->price_in = $post['price_in'] ?? 0.0;
        $model->quantity = $post['quantity'] ?? 1;
        $model->catalog_product_id = $post['catalog_product_id'];
        return $model->safe();
    }

    public function getCatalogStoragePlace()
    {
        return $this->hasOne(CatalogStoragePlace::class, ['id' => 'catalog_storage_place_id']);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(CatalogDocument::class, 'catalog_document_id', 'id');
    }

    public function getCatalogProduct()
    {
        return $this->hasOne(CatalogProduct::class, ['id' => 'catalog_product_id']);
    }

    public function posting(CatalogDocumentSubject $subject): self
    {
        /* @var $storage CatalogStorage */
        $this->subject = $subject->name;
        $storage = CatalogStorage::createOrUpdate($this);
        if ($errors = $storage->getErrors()) {
            return $this->setErrors($errors);
        }
        if (!empty($storage->id)) {
            $this->catalog_storage_id = $storage->id;
            /* @var $product CatalogProduct */
            if ($product = CatalogProduct::query()->where('is_published', 0)->find($this->catalog_product_id)) {
                $product->is_published = 1;
                $product->setDocument = false;
                if ($product->safe()->getErrors()) {
                    return $this->setErrors(['catalog_product' => 'Товар не обновился']);
                }
                return $this->safe();
            }
            return $this->safe();
        }
        return $this->setErrors(['catalog_storage_id' => 'Должна быть принадлежность к складу']);
    }

    public static function deleteContent(int $id): bool
    {

        $model = self::query()
            ->select([self::table('*')])
            ->join(CatalogDocument::table(), static function ($join) {
                $join->on(CatalogDocument::table('id'), '=', self::table('catalog_document_id'))
                    ->where(CatalogDocument::table('status'), '!=', CatalogDocument::STATUS_POST);
            })->find($id);
        return $model && $model->delete();
    }
}
