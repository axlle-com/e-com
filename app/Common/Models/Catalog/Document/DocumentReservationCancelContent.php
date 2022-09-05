<?php

namespace App\Common\Models\Catalog\Document;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Common\Models\Catalog\Document\Main\DocumentContentBase;

/**
 * This is the model class for table "{{%ax_document_reservation_cancel_content}}".
 *
 * @property DocumentReservationCancel $document
 */
class DocumentReservationCancelContent extends DocumentContentBase
{
    protected $table = 'ax_document_reservation_cancel_content';

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentReservationCancel::class, 'document_id', 'id');
    }
}
