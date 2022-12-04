<?php

namespace App\Common\Jobs;

use App\Common\Models\Catalog\Document\Main\Document;
use App\Common\Models\Catalog\Document\ReservationCancel\DocumentReservationCancel;
use App\Common\Models\Catalog\Storage\CatalogStorageReserve;
use App\Common\Models\Errors\_Errors;
use Exception;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ReservationCancelJob extends BaseJob
{
    public Document $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->delay(CatalogStorageReserve::EXPIRED_AT_DELAY + 10);
        parent::__construct();
    }

    public function handle()
    {
        $self = $this;
        try {
            DB::transaction(static function () use ($self) {
                $data = [];
                $data['catalog_storage_place_id'] = $self->document->catalog_storage_place_id;
                $data['contents'][0]['quantity'] = $self->document->quantity;
                $data['contents'][0]['document_id'] = $self->document->document_id;
                $data['contents'][0]['price'] = $self->document->price;
                $data['contents'][0]['catalog_product_id'] = $self->document->catalog_product_id;
                $document = DocumentReservationCancel::createOrUpdate($data)->posting(false);
                if ($document->getErrors()) {
                    throw new RuntimeException('Ошибка сохранения складов: ' . $document->getErrors()->getMessage());
                }
            }, 3);
        } catch (Exception $exception) {
            $self->setErrors(_Errors::exception($exception, $self));
        }
        parent::handle();
    }
}