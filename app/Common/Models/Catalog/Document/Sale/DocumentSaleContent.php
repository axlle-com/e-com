<?php

namespace App\Common\Models\Catalog\Document\Sale;

use App\Common\Models\Catalog\Document\DocumentContentBase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%ax_document_sale_content}}".
 *
 * @property DocumentSale $document
 */
class DocumentSaleContent extends DocumentContentBase
{
    protected $table = 'ax_document_sale_content';

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentSale::class, 'document_id', 'id');
    }
}
