<?php

namespace App\Common\Models\Catalog\Document\Reservation;

use App\Common\Models\Catalog\Document\DocumentContentBase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%ax_document_reservation_content}}".
 *
 * @property DocumentReservation $document
 */
class DocumentReservationContent extends DocumentContentBase
{
    protected $table = 'ax_document_reservation_content';

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentReservation::class, 'document_id', 'id');
    }
}
