<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Components\Bank\Alfa;
use App\Common\Components\Mail\NotifyAdmin;
use App\Common\Components\Mail\NotifyOrder;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogCoupon;
use App\Common\Models\Catalog\CatalogDeliveryStatus;
use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogPaymentStatus;
use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\FinTransactionType;
use App\Common\Models\User\Counterparty;
use App\Common\Models\User\UserWeb;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * This is the model class for table "{{%ax_document_order}}".
 *
 * @property int $id
 * @property string $uuid
 * @property int $counterparty_id
 * @property int $catalog_payment_type_id
 * @property int $catalog_delivery_type_id
 * @property int $catalog_sale_document_id
 * @property int $catalog_reserve_document_id
 * @property int $payment_order_id
 * @property int|null $ips_id
 * @property int|null $catalog_coupon_id
 * @property int|null $catalog_delivery_status_id
 * @property int|null $catalog_payment_status_id
 * @property float|null $delivery_cost
 * @property string|null $delivery_address
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket|null $basketProducts
 * @property Counterparty|null $counterparty
 * @property DocumentOrderContent[] $contentsWithout
 */
class DocumentOrder extends DocumentBase
{
    public static array $fields = [
        'counterparty',
        'delivery',
        'payment',
    ];
    private static ?self $_self = null;
    public string $paymentUrl = '';
    public array $paymentData = [];
    public float $amount = 0.0;
    public bool $isNew = false;
    public bool $isCreateDocument = false;
    protected $table = 'ax_document_order';
    protected $fillable = [
        'id',
        'uuid',
        'user_id',
        'catalog_payment_type_id',
        'catalog_delivery_type_id',
        'catalog_sale_document_id',
        'catalog_reserve_document_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'user_id' => 'integer',
        'catalog_payment_type_id' => 'integer',
        'catalog_delivery_type_id' => 'integer',
        'catalog_sale_document_id' => 'integer',
        'catalog_reserve_document_id' => 'integer',
        'ips_id' => 'integer',
        'status' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
                    'id' => 'nullable|integer',
                    'user.first_name' => 'required|string',
                    'user.last_name' => 'required|string',
                    'user.phone' => 'required|string',
                    'order.catalog_payment_type_id' => 'required|integer',
                    'order.catalog_delivery_type_id' => 'required|integer',
                ],
                'posting' => [
                    'id' => 'required|integer',
                    'catalog_payment_type_id' => 'required|integer',
                    'catalog_delivery_type_id' => 'required|integer',
                    'catalog_sale_document_id' => 'required|integer',
                    'catalog_reserve_document_id' => 'required|integer',
                    'payment_order_id' => 'required|integer',
                ],
            ][$type] ?? [];
    }

    public static function validate(array $post): array
    {
        $array = [];
        $delivery_address = isset($post['order']['delivery_address']);
        $address_city = isset($post['address']['city']);
        $address_street = isset($post['address']['street']);
        $address_house = isset($post['address']['house']);
        $address_apartment = isset($post['address']['apartment']);
        if ($delivery_address || ($address_city && $address_street && $address_house && $address_apartment)) {
            return $array;
        }
        if (!$delivery_address) {
            $array['order.delivery_address'] = 'Поле не может быть пустым';
        }
        if (!$address_city) {
            $array['address.city'] = 'Поле не может быть пустым';
        }
        if (!$address_street) {
            $array['address.street'] = 'Поле не может быть пустым';
        }
        if (!$address_house) {
            $array['address.house'] = 'Поле не может быть пустым';
        }
        if (!$address_apartment) {
            $array['address.apartment'] = 'Поле не может быть пустым';
        }
        return $array;
    }

    public static function createOrUpdate(array $post, bool $isEvent = true): static
    {
        $id = empty($post['id']) ? null : $post['id'];
        $uuid = empty($post['uuid']) ? null : $post['uuid'];
        $model = null;
        $user = empty($post['user_id']) ? null : $post['user_id'];
        $counterparty = empty($post['counterparty_id']) ? null : $post['counterparty_id'];
        if (!($counterparty || $user)) {
            return (new self())->setErrors(_Errors::error(['user' => 'Необходимо заполнить пользователя'], new self()));
        }
        if ($id || $uuid) {
            $model = self::filter()
                ->when($id, function ($query, $id) {
                    $query->where(self::table('id'), $id);
                })
                ->when($uuid, function ($query, $uuid) {
                    $query->where(self::table('uuid'), $uuid);
                })
                ->first();
        }
        if ($user && !$model && !$model = self::getByUser($user)) {
            $model = new self();
            $model->uuid = Str::uuid();
            $model->isNew = true;
        } elseif ($counterparty && !$model && !$model = self::getByCounterparty($counterparty)) {
            $model = new self();
            $model->uuid = Str::uuid();
            $model->isNew = true;
        }
        if ($post['coupon'] ?? null) {
            /* @var $coupon CatalogCoupon */
            $coupon = CatalogCoupon::query()
                ->where('value', $post['coupon'])
                ->where('status', CatalogCoupon::STATUS_NEW)
                ->first();
            if ($coupon) {
                $model->catalog_coupon_id = $coupon->id;
            }
        }
        $model->status = $post['status'] ?? self::STATUS_NEW;
        $model->catalog_payment_type_id = $post['catalog_payment_type_id'] ?? null;
        $model->catalog_payment_status_id = $post['catalog_payment_status_id']
            ?? CatalogPaymentStatus::query()->where('key', 'not_paid')->first()->id
            ?? null;
        $model->catalog_delivery_type_id = $post['catalog_delivery_type_id'] ?? null;
        $model->catalog_delivery_status_id = $post['catalog_delivery_status_id']
            ?? CatalogDeliveryStatus::query()->where('key', 'in_processing')->first()->id
            ?? null;
        $model->delivery_cost = CatalogDeliveryType::query()->find($post['catalog_delivery_type_id'])->cost ?? null;
        $model->delivery_address = $post['delivery_address'] ?? null;
        $model->payment_order_id = $post['payment_order_id'] ?? null;
        $model->catalog_storage_place_id = $post['catalog_storage_place_id']
            ?? CatalogStoragePlace::query()->where('is_place', 1)->first()->id
            ?? null;
        $model->setFinTransactionTypeId();
        $model->setCounterpartyId($counterparty);
        $model->setUserId($user);
        if (!$model->safe()->getErrors()) {
            $up = CatalogBasket::query()
                ->where('user_id', $model->counterparty->user_id)
                ->where('status', '=', self::STATUS_NEW)
                ->update(['document_order_id' => $model->id]);
            $model->checkProduct();
        }
        $model->isCreateDocument = $model->status === self::STATUS_POST;
        return $model;
    }

    public static function getByUser(int $user_id): ?self # TODO: найти повторы за один запрос
    {
        /* @var $self self */
        $counterparty = self::getCounterparty($user_id);
        $self = self::filter()
            ->with(['basketProducts'])
            ->where(self::table('counterparty_id'), $counterparty->id)
            ->where(self::table('status'), self::STATUS_NEW)
            ->first();
        return $self;
    }

    public static function getCounterparty($user_id): Counterparty # TODO: заджойнить при входе
    {
        $counterparty = Counterparty::query()
            ->select([Counterparty::table('id')])
            ->where(Counterparty::table('user_id'), $user_id)
            ->where(Counterparty::table('is_individual'), 1)
            ->first();
        if (!$counterparty) {
            $counterparty = Counterparty::createOrUpdate(['user_id' => $user_id, 'is_individual' => 1]);
        }
        return $counterparty;
    }

    public static function getByCounterparty(int $counterparty_id): ?self
    {
        /* @var $self self */
        $self = self::filter()
            ->with(['basketProducts'])
            ->where(self::table('counterparty_id'), $counterparty_id)
            ->where(self::table('status'), self::STATUS_NEW)
            ->first();
        return $self;
    }

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::debit()->id ?? null;
        return $this;
    }

    public function setUserId(?int $user_id = null): self
    {
        if (empty($this->counterparty_id)) {
            $counterparty = self::getCounterparty($user_id);
            $this->counterparty_id = $counterparty->id;
        }
        return $this;
    }

    public function checkProduct(): void
    {
        $this->load('basketProducts');
        foreach ($this->basketProducts as $product) {
            if ($product->quantity > ($product->in_stock + $product->in_reserve)) {
                $this->setErrors(_Errors::error(['product' => 'Товара: ' . $product->title . ' не достаточно на остатках'], $this));
            }
        }
    }

    public static function getAllByUser(int $user_id): ?Collection
    {
        /* @var $self self */
        $counterparty = self::getCounterparty($user_id);
        $self = self::filter()
            ->with(['contents'])
            ->where(self::table('counterparty_id'), $counterparty->id)
            ->get();
        return $self;
    }

    public static function getByUuid(int $user_id, string $uuid): ?self
    {
        /* @var $self self */
        $counterparty = self::getCounterparty($user_id);
        $self = self::filter()
            ->with(['contents'])
            ->where(self::table('counterparty_id'), $counterparty->id)
            ->where(self::table('uuid'), $uuid)
            ->first();
        return $self;
    }

    public static function getLastPaid(int $user_id): ?self
    {
        /* @var $self self */
        $counterparty = self::getCounterparty($user_id);
        $self = self::filter()
            ->with(['contents'])
            ->where(self::table('status'), self::STATUS_POST)
            ->where(self::table('counterparty_id'), $counterparty->id)
            ->where(CatalogPaymentStatus::table('key'), 'paid')
            ->orderByDesc('updated_at')
            ->first();
        return $self;
    }

    public function sale(): static
    {
        $doc = DocumentSale::createOrUpdate($this->getDataForDocumentTarget());
        if ($err = $doc->getErrors()) {
            $this->setErrors($err);
        } elseif ($err = $doc->posting()->getErrors()) {
            $this->setErrors($err);
        }
        $this->catalog_payment_status_id = CatalogPaymentStatus::query()
                ->where('key', 'paid')
                ->first()->id
            ?? $this->catalog_payment_status_id;
        return $this->safe();
    }

    public function getDataForDocumentTarget(): array
    {
        $contents = DocumentOrderContent::query()
            ->select([
                'catalog_product_id',
                'quantity',
                'price',
            ])
            ->where('document_id', $this->id)
            ->get()
            ->toArray();
        return [
            'counterparty_id' => $this->counterparty_id,
            'status' => self::STATUS_POST,
            'contents' => $contents,
            'document' => [
                'model' => $this->getTable(),
                'model_id' => $this->id,
            ]
        ];
    }

    public function rollBack(): static
    {
        $self = $this;
        try {
            DB::transaction(static function () use ($self) {
                $doc = DocumentReservationCancel::createOrUpdate($self->getDataForDocumentTarget());
                if ($err = $doc->getErrors()) {
                    $self->setErrors($err);
                } elseif ($err = $doc->posting(false)->getErrors()) {
                    $self->setErrors($err);
                }
                $contents = DocumentOrderContent::query()
                    ->where('document_id', $self->id)
                    ->count();
                $up = CatalogBasket::query()
                    ->where('user_id', $self->counterparty->user_id)
                    ->where('status', '=', self::STATUS_POST)
                    ->where('document_order_id', $self->id)
                    ->update(['status' => self::STATUS_NEW, 'document_order_id' => null]);
                if ($contents !== $up) {
                    $self->setErrors(_Errors::error('При сохранении корзины возникли ошибки', $self));
                }
                if ($self->getErrors()) {
                    throw new \RuntimeException('При сохранении возникли ошибки');
                }
            }, 3);
        } catch (Exception $exception) {
            $this->setErrors(_Errors::error($self->getErrors()?->getErrors(), $this));
        }
        return $this;
    }

    public function checkPay(): bool
    {
        $alfa = (new Alfa())
            ->setMethod('/getOrderStatus.do')
            ->setBody(['orderId' => $this->payment_order_id])
            ->send();
        if ($alfa->getErrors()) {
            return false;
        }
        $this->paymentData = $alfa->getData();
        return $this->paymentData['OrderStatus'] === 2 && $this->status === self::STATUS_POST;
    }

    public function notifyAdmin(string $message): self
    {
        try {
            Mail::to(config('app.admin_email'))->send(new NotifyAdmin($message));
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        return $this;
    }

    public function notify(): self
    {
        try {
            Mail::to(config('app.admin_email'))->send(new NotifyOrder($this));
            if (($user = UserWeb::auth()) && $user->email) {
                Mail::to($user->email)->send(new NotifyOrder($this));
            }
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        return $this;
    }

    public function posting(bool $transaction = true): static
    {
        DB::beginTransaction();
        if ($this->getErrors()) {
            return $this;
        }
        DocumentReservationCancel::reservationCheck();
        $this->status = self::STATUS_POST;
        $this->load('basketProducts');
        $this->setContents($this->basketProducts->toArray());
        if (($contents = $this->contents) && count($contents)) {
            foreach ($contents as $content) {
                $this->amount += ($content->price * $content->quantity);
                if ($error = $content->posting()->getErrors()) { # TODO: посмотреть на количество запросов
                    $this->setErrors($error);
                }
            }
        }
        if ($errors = $this->getErrors()) {
            DB::rollBack();
            return $this->setErrors($errors);
        }
        $this->pay();
        $countContents = count($this->contents);
        unset($this->contents);
        if ($this->getErrors() || $this->safe()->getErrors()) {
            DB::rollBack();
        } else {
            $up = CatalogBasket::query()
                ->where('user_id', $this->counterparty->user_id)
                ->where('status', '!=', self::STATUS_POST)
                ->where('document_order_id', $this->id)
                ->update(['status' => self::STATUS_POST]);
            if ($countContents === $up) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        }
        return $this;
    }

    public function pay(): static
    {
        $pay = (new Alfa())
            ->setMethod('/register.do')
            ->setBody(['amount' => ($this->amount + $this->delivery_cost) * 100, 'orderNumber' => $this->uuid])
            ->send();
        if ($pay->getErrors()) {
            return $this->setErrors($pay->getErrors());
        }
        $data = $pay->getData();
        if (empty($data['orderId']) || empty($data['formUrl'])) {
            return $this->setErrors(_Errors::error($pay::DEFAULT_MESSAGE_ERROR, $this));
        }
        $this->payment_order_id = $data['orderId'];
        $this->status = static::STATUS_POST;
        $this->paymentUrl = $data['formUrl'];
        return $this;
    }

    public function basketProducts(): HasMany
    {
        $self = $this;
        return $this->hasMany(CatalogBasket::class, 'document_order_id', 'id')
            ->select([
                CatalogBasket::table('*'),
                CatalogProduct::table('title') . ' as title',
                CatalogStorage::table('price_out') . ' as price',
                CatalogStorage::table('in_stock') . ' as in_stock',
                CatalogStorage::table('in_reserve') . ' as in_reserve',
            ])
            ->join(CatalogProduct::table(), CatalogProduct::table('id'), '=', CatalogBasket::table('catalog_product_id'))
            ->join(CatalogStorage::table(), static function ($join) use ($self) { # TODO: выборку сделать с учетом просроченного резерва --- теперь проверить
                $catalogStoragePlaceId = $self->catalog_storage_place_id;
                $join->on(CatalogStorage::table('catalog_product_id'), '=', CatalogProduct::table('id'))
                    ->when($catalogStoragePlaceId, function ($query, $catalogStoragePlaceId) {
                        $query->where(CatalogStorage::table('catalog_storage_place_id'), '=', $catalogStoragePlaceId)
                            ->where(function ($query) {
                                $query->where(CatalogStorage::table('in_stock'), '>', 0)
                                    ->orWhere(static function ($query) {
                                        $query->where(CatalogStorage::table('in_reserve'), '>', 0)
                                            ->where(CatalogStorage::table('reserve_expired_at'), '<', time());
                                    });
                            });
                    });
            });
    }

    public function counterparty(): BelongsTo
    {
        return $this->BelongsTo(Counterparty::class, 'counterparty_id', 'id');
    }
}
