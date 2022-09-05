<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\FinTransactionType;
use App\Common\Models\Catalog\Document\Main\DocumentBase;

/**
 * This is the model class for table "{{%ax_document_sale}}".
 *
 * @property DocumentSaleContent[] $contents
 */
class DocumentSale extends DocumentBase
{
    public static array $fields = [
        'counterparty',
    ];

    protected $table = 'ax_document_sale';

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::debit()->id ?? null;
        return $this;
    }
}
