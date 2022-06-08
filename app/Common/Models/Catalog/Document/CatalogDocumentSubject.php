<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\FinTransactionType;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_catalog_document_subject".
 *
 * @property int $id
 * @property int $fin_transaction_type_id
 * @property string $name
 * @property string $title
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property int|null $type_id
 * @property string|null $type_name
 *
 * @property CatalogDocument[] $catalogDocuments
 * @property FinTransactionType $finTransactionType
 */
class CatalogDocumentSubject extends BaseModel
{
    protected $table = 'ax_catalog_document_subject';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function getByName(string $name): ?self
    {
        /* @var $subject self */
        $subject = self::query()
            ->select([
                'ax_catalog_document_subject.*',
                't.id as type_id',
                't.name as type_name',
            ])
            ->join('ax_fin_transaction_type as t', 't.id', '=', 'ax_catalog_document_subject.fin_transaction_type_id')
            ->where('ax_catalog_document_subject.name', $name)
            ->first();
        return $subject ?: null;
    }
}
