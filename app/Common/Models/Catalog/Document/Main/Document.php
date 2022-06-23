<?php

namespace App\Common\Models\Catalog\Document\Main;

use App\Common\Models\Main\Errors;

/**
 * This is the model class for storage.
 *
 */
class Document
{
    use Errors;

    public int|null $document_id = null;
    public string|null $document = null;
    public string|null $document_target = null;
    public int|null $document_id_target = null;
    public int|null $catalog_storage_id = null;
    public int|null $catalog_product_id = null;
    public int|null $catalog_storage_place_id = null;
    public int|null $catalog_storage_place_id_target = null;
    public float|null $price = null;
    public int|null $quantity = null;
    public string|null $subject = null;

    public function __construct(DocumentContentBase $content)
    {
        $this->document_id = $content->document_id;
        $this->document = $content->document->getTable();
        $this->document_id_target = $content->document->document_id;
        $this->document_target = $content->document->document;
        $this->catalog_storage_id = $content->catalog_storage_id;
        $this->catalog_product_id = $content->catalog_product_id;
        $this->price = $content->price;
        $this->quantity = $content->quantity;
        $this->catalog_storage_place_id = $content->document->catalog_storage_place_id;
        $this->subject = DocumentBase::$types[$content->document::class]['key'];
    }

}