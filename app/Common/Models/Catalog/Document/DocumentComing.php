<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\DocumentSetter;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\Main\Status;

/**
 * This is the model class for table "{{%ax_document_coming}}".
 *
 * @property int $id
 * @property int $counterparty_id
 * @property string|null $document
 * @property int|null $document_id
 * @property int $fin_transaction_type_id
 * @property int $catalog_storage_place_id
 * @property int|null $currency_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogDocumentContent[] $contents
 */
class DocumentComing extends BaseModel implements Status
{
    use EventSetter, DocumentSetter;

    public string $key = 'coming';
    protected $table = 'ax_document_coming';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
                    'id' => 'nullable|integer',
                    'content' => 'required|array',
                    'content.*.catalog_product_id' => 'required|integer',
                    'content.*.price' => 'nullable|numeric',
                    'content.*.quantity' => 'required|numeric|min:1',
                ],
                'posting' => [
                    'id' => 'required|integer',
                    'content' => 'required|array',
                    'content.*.catalog_product_id' => 'required|integer',
                    'content.*.price' => 'nullable|numeric',
                    'content.*.quantity' => 'required|numeric|min:1',
                ],
            ][$type] ?? [];
    }

    public static function createOrUpdate(array $post): self
    {
        if (empty($post['id']) || !$model = self::filter()->where(self::table('id'), $post['id'])
                ->first()) {
            $model = new self();
            $model->status = self::STATUS_NEW;
        }
        $model->setDocument($post['document'] ?? null);
        $model->catalog_storage_place_id = $post['catalog_storage_place_id'] ?? null;
        $model->setContent($post['content'] ?? null);
        return $model;
    }
}
