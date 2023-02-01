<?php

namespace App\Common\Models\Catalog\Document\ReservationCancel;

use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\FinTransactionType;
use App\Common\Models\Catalog\Storage\CatalogStorageReserve;
use App\Common\Models\Errors\_Errors;
use Exception;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * This is the model class for table "{{%ax_document_reservation_cancel}}".
 *
 * @property int|null $count
 * @property DocumentReservationCancelContent[] $contents
 */
class DocumentReservationCancel extends DocumentBase
{
    protected $table = 'ax_document_reservation_cancel';
    protected $fillable = [
        'id',
        'catalog_storage_place_id',
        'fin_transaction_type_id',
        'document',
        'document_id',
        'currency_id',
        'status',
    ];

    public static function reservationCheck(int $id = null): self # TODO: !!! Вынести в exec()? !!!
    {
        $self = new self();
        $reserve = CatalogStorageReserve::query()->when($id, function ($query, $id) {
            $query->where('catalog_product_id', $id);
        })->where('expired_at', '<', time())->where('in_reserve', '>', 0)->get();
        if ($count = count($reserve)) {
            $arrayStorageReserve = [];
            foreach ($reserve as $item) {
                /** @var $item CatalogStorageReserve */
                $arrayStorageReserve[$item->catalog_storage_place_id]['contents'][] = [
                    'catalog_product_id' => $item->catalog_product_id,
                    'quantity' => $item->in_reserve,
                ];
            }
            try {
                DB::transaction(static function () use ($arrayStorageReserve, $self) {
                    foreach ($arrayStorageReserve as $storage => $contents) {
                        $data = [];
                        $data['catalog_storage_place_id'] = $storage;
                        $data['contents'] = $contents['contents'];
                        $self = self::createOrUpdate($data)->posting(false);
                    }
                    if ($self->getErrors()) {
                        throw new RuntimeException('Ошибка сохранения складов: ' . $self->getErrors()->getMessage());
                    }
                }, 3);
            } catch (Exception $exception) {
                $self->setErrors(_Errors::exception($exception, $self));
            }
            $self->count = $count;
        }
        return $self;
    }

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::credit()->id ?? null;
        return $this;
    }

    protected function setDefaultValue(): static
    {
        $this->setFinTransactionTypeId();
        $this->setCatalogStoragePlaceId();
        return $this;
    }

    public function setCatalogStoragePlaceId($catalog_storage_place_id = null): static
    {
        $this->catalog_storage_place_id = $catalog_storage_place_id
            ?? CatalogStoragePlace::query()
            ->where('is_place', 1)
            ->first()->id;
        return $this;
    }

}
