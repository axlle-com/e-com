<?php

namespace App\Common\Models\Catalog\Document\Financial;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Common\Models\Catalog\Document\Main\DocumentContentBase;

/**
 * This is the model class for table "{{%ax_document_fin_invoice_content}}".
 *
 */
class DocumentFinInvoiceContent extends DocumentContentBase
{
    protected $table = 'ax_document_fin_invoice_content';

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentFinInvoice::class, 'document_id', 'id');
    }
}
