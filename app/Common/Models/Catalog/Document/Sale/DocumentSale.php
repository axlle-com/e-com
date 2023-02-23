<?php

namespace App\Common\Models\Catalog\Document\Sale;

use App\Common\Models\Catalog\Document\DocumentBase;
use App\Common\Models\FinTransactionType;

/**
 * This is the model class for table "{{%ax_document_sale}}".
 *
 * @property DocumentSaleContent[] $contents
 */
class DocumentSale extends DocumentBase
{
    public static array $fields = ['counterparty',];

    protected $table = 'ax_document_sale';

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::debit()->id ?? null;
        return $this;
    }
}
