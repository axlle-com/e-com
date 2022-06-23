<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\FinTransactionType;

/**
 * This is the model class for table "{{%ax_document_reservation_cancel}}".
 *
 * @property DocumentReservationCancelContent[] $contents
 */
class DocumentReservationCancel extends DocumentBase
{
    protected $table = 'ax_document_reservation_cancel';

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::credit()->id ?? null;
        return $this;
    }
}
