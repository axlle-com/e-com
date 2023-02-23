<?php

namespace App\Common\Models\Catalog\Document\WriteOff;

use App\Common\Models\Catalog\Document\DocumentContentBase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%ax_document_coming_content}}".
 *
 * @property DocumentWriteOff $document
 */
class DocumentWriteOffContent extends DocumentContentBase
{
    protected $table = 'ax_document_write_off_content';

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentWriteOff::class, 'document_id', 'id');
    }
}
