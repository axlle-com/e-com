<?php

namespace App\Common\Models\Catalog\Document;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Common\Models\Catalog\Document\Main\DocumentContentBase;

/**
 * This is the model class for table "{{%ax_document_coming_content}}".
 *
 * @property float|null $price_out
 * @property DocumentComing $document
 */
class DocumentComingContent extends DocumentContentBase
{
    protected $table = 'ax_document_coming_content';

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentComing::class, 'document_id', 'id');
    }

    public function setPrice($post): static
    {
        $this->price = $post['price'] ?? 0.0;
        $this->price_out = $post['price_out'] ?? 0.0;
        return $this;
    }
}
