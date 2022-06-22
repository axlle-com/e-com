<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\FinTransactionType;

/**
 * This is the model class for table "{{%ax_document_coming}}".
 *
 * @property DocumentComingContent[] $contents
 */
class DocumentComing extends DocumentBase
{
    public static array $fields = [
        'storage',
        'counterparty',
    ];

    protected $table = 'ax_document_coming';

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::credit()->id ?? null;
        return $this;
    }
}
