<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Jobs\ReservationCancelJob;
use App\Common\Models\Catalog\Document\Order\DocumentOrder;
use App\Common\Models\Catalog\Storage\CatalogStorageReserve;
use App\Common\Models\Main\BaseComponent;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * This is the model class for storage.
 *
 */
class Document extends BaseComponent
{
    use DispatchesJobs;

    public int|null $document_id = null;
    public string|null $document = null;
    public string|null $document_target = null;
    public int|null $document_id_target = null;
    public int|null $catalog_storage_id = null;
    public int|null $catalog_product_id = null;
    public int|null $catalog_storage_place_id = null;
    public int|null $catalog_storage_place_id_target = null;
    public int|null $expired_at = null;
    public float|null $price = null;
    public float|null $price_out = null;
    public int|null $quantity = null;
    public string|null $subject = null;

    public static function document(DocumentContentBase $content): self
    {
        $self = new self();
        $self->document_id = $content->document_id;
        $self->document = $content->document->getTable();
        $self->document_id_target = $content->document->document_id;
        $self->document_target = $content->document->document;
        $self->catalog_storage_id = $content->catalog_storage_id;
        $self->catalog_product_id = $content->catalog_product_id;
        $self->price = $content->price;
        $self->price_out = $content->price_out ?? null;
        $self->quantity = $content->quantity;
        $self->expired_at = $content->document->expired_at ?? null;
        $self->catalog_storage_place_id = $content->document->catalog_storage_place_id;
        $self->subject = DocumentBase::$types[$content->document::class]['key'];
        return $self;
    }

    public static function order(DocumentOrder $content) {}

    public function reservationCancelJob(): void
    {
        ReservationCancelJob::dispatch($this)->delay(CatalogStorageReserve::EXPIRED_AT_DELAY + 10);
    }

}
