<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Main\DocumentSetter;

/**
 * This is the model class for table "{{%ax_document_coming}}".
 *
 *
 * @property DocumentComingContent[] $contents
 */
class DocumentWriteOff extends DocumentBase
{
    protected $table = 'ax_document_write_off';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
                    'id' => 'nullable|integer',
                    'content' => 'required|array',
                    'content.*.catalog_product_id' => 'required|integer',
                    'content.*.price' => 'nullable|numeric',
                    'content.*.quantity' => 'required|numeric|min:1',
                ],
                'posting' => [
                    'id' => 'required|integer',
                    'content' => 'required|array',
                    'content.*.catalog_product_id' => 'required|integer',
                    'content.*.price' => 'nullable|numeric',
                    'content.*.quantity' => 'required|numeric|min:1',
                ],
            ][$type] ?? [];
    }
}
