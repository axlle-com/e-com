<?php

namespace App\Common\Models\Catalog\Document\Order;

use App\Common\Models\Catalog\Document\DocumentContentBase;
use App\Common\Models\Catalog\Document\Reservation\DocumentReservation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%ax_document_order_content}}".
 *
 * @property DocumentReservation $document
 */
class DocumentOrderContent extends DocumentContentBase
{
    protected $table = 'ax_document_order_content';

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentOrder::class, 'document_id', 'id');
    }
}
