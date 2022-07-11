<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\FinTransactionType;

/**
 * This is the model class for table "{{%ax_document_reservation}}".
 *
 * @property int|null $expired_at
 *
 * @property DocumentReservationContent[] $contents
 */
class DocumentReservation extends DocumentBase
{
    public static array $fields = [
        'counterparty',
        'expired_at',
    ];

    protected $table = 'ax_document_reservation';

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::debit()->id ?? null;
        return $this;
    }

    public function setCounterpartyId($counterparty_id = null): static
    {
        $this->counterparty_id = $counterparty_id;
        return $this;
    }
}
