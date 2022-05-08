<?php

namespace App\Common\Models\Catalog;

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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogDocuments()
    {
        return $this->hasMany(CatalogDocument::className(), ['catalog_document_subject_id' => 'id']);
    }

    public function getFinTransactionType()
    {
        return $this->hasOne(FinTransactionType::className(), ['id' => 'fin_transaction_type_id']);
    }
}
