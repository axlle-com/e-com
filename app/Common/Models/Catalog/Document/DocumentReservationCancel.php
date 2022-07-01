<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Catalog\Storage\CatalogStorageReserve;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\FinTransactionType;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "{{%ax_document_reservation_cancel}}".
 *
 * @property DocumentReservationCancelContent[] $contents
 */
class DocumentReservationCancel extends DocumentBase
{
    protected $table = 'ax_document_reservation_cancel';

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::credit()->id ?? null;
        return $this;
    }

    public static function reservationCheck(): self
    {
        $self = new self();
        $reserve = CatalogStorageReserve::query()
            ->where('expired_at', '<', time())
            ->where('in_reserve', '>', 0)
            ->get();
        if (count($reserve)) {
            $arrayStorageReserve = [];
            foreach ($reserve as $item) {
                /* @var $item CatalogStorageReserve */
                $arrayStorageReserve['contents'][] = [
                    'catalog_product_id' => $item->catalog_product_id,
                    'quantity' => $item->in_reserve,
                ];
            }
            try {
                DB::transaction(static function () use ($arrayStorageReserve) {
                    $self = DocumentReservationCancel::createOrUpdate($arrayStorageReserve)->posting();
                    if ($self->getErrors()) {
                        throw new \RuntimeException('Ошибка сохранения складов');
                    }
                }, 3);
            } catch (\Exception $exception) {
                $self->setErrors(_Errors::exception($exception,$self));
            }
        }
        return $self;
    }
}
