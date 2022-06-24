<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogCoupon;
use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\FinTransactionType;
use App\Common\Models\User\Counterparty;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
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
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket|null $basketProducts
 * @property Counterparty|null $counterparty
 */
class DocumentOrder extends DocumentBase
{
    public bool $isNew = false;
    public bool $isCreateDocument = false;

    private static ?self $_self = null;

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

    public function createDocument(): void
    {
        if ($this->status === self::STATUS_POST) {
            $this->load('basketProducts');
            $data = [
                'counterparty_id' => $this->counterparty_id,
                'status' => self::STATUS_POST,
                'contents' => $this->basketProducts->toArray(),
                'document' => [
                    'model' => $this->getTable(),
                    'model_id' => $this->id,
                ]
            ];
            $doc = DocumentSale::createOrUpdate($data);
            if ($err = $doc->getErrors()) {
                $this->setErrors($err);
            } elseif ($err = $doc->posting()->getErrors()) {
                $this->setErrors($err);
            }
        }
    }

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
                    'address.region' => 'nullable|string',
                    'address.city' => 'required|string',
                    'address.street' => 'required|string',
                    'address.house' => 'required|string',
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

    public static function createOrUpdate(array $post, bool $isEvent = true): static
    {
        $id = empty($post['id']) ? null : $post['id'];
        $uuid = empty($post['uuid']) ? null : $post['uuid'];
        $model = null;
        $user = empty($post['user_id']) ? null : $post['user_id'];
        if (!$user) {
            return (new self())->setErrors(['user' => 'Необходимо заполнить пользователя']);
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
        if (!$model && !$model = self::getByUser($user)) {
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
        $model->catalog_delivery_type_id = $post['catalog_delivery_type_id'] ?? null;
        $model->payment_order_id = $post['payment_order_id'] ?? null;
        $model->catalog_storage_place_id = $post['catalog_storage_place_id']
            ?? CatalogStoragePlace::query()
                ->where('is_place', 1)
                ->first()->id;
        $model->setFinTransactionTypeId();
        $model->setCounterparty($user);
        if (!$model->safe()->getErrors()) {
            $up = CatalogBasket::query()
                ->where('user_id', $model->counterparty->user_id)
                ->where('status', '!=', self::STATUS_POST)
                ->update(['document_order_id' => $model->id]);
            $model->checkProduct();
        }
        $model->isCreateDocument = $model->status === self::STATUS_POST;
        return $model;
    }

    public function checkProduct(): void
    {
        $this->load('basketProducts');

        foreach ($this->basketProducts as $product) {
            if ($product->quantity > ($product->in_stock + $product->in_reserve)) {
                $this->setErrors(['product' => 'Нет товара на остатках']);
                break;
            }
        }
    }

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::debit()->id ?? null;
        return $this;
    }

    public static function getByUser(int $user_id): ?self
    {
        /* @var $self self */
        if (!self::$_self) {
            $counterparty = self::getCounterparty($user_id);
            self::$_self = self::filter()
                ->with(['basketProducts'])
                ->where(self::table('counterparty_id'), $counterparty->id)
                ->where(self::table('status'), self::STATUS_NEW)
                ->first();
        }
        return self::$_self;
    }

    public static function deleteById(int $id)
    {
        $item = self::query()
            ->where('id', $id)
            ->where('status', '!=', self::STATUS_POST)
            ->first();
        if ($item) {
            return $item->delete();
        }
        return false;
    }

    public function sale(): static
    {
        $this->load('contents');
        $data = [
            'counterparty_id' => $this->counterparty_id,
            'status' => self::STATUS_POST,
            'contents' => $this->contents->toArray(),
            'document' => [
                'model' => $this->getTable(),
                'model_id' => $this->id,
            ]
        ];
        $doc = DocumentSale::createOrUpdate($data);
        if ($err = $doc->getErrors()) {
            $this->setErrors($err);
        } elseif ($err = $doc->posting()->getErrors()) {
            $this->setErrors($err);
        }
        return $this;
    }

    public function posting(): static
    {
        DB::beginTransaction();
        $errors = [];
        if ($this->getErrors()) {
            return $this;
        }
        $this->status = self::STATUS_POST;
        $this->load('basketProducts');
        $this->setContent($this->basketProducts->toArray());
        if (($contents = $this->contents) && count($contents)) {
            foreach ($contents as $content) {
                if ($error = $content->posting()->getErrors()) {
                    $errors[] = true;
                    $this->setErrors($error);
                }
            }
        }
        if ($errors) {
            DB::rollBack();
            return $this;
        }
        $this->status = static::STATUS_POST;
        unset($this->contents);
        if ($this->safe()->getErrors()) {
            DB::rollBack();
        } else {
            DB::commit();
        }
        return $this;
    }

    public function basketProducts(): HasMany
    {
        $self = $this;
        return $this->hasMany(CatalogBasket::class, 'document_order_id', 'id')
            ->select([
                CatalogBasket::table('*'),
                CatalogProduct::table('title') . ' as product_title',
                CatalogProduct::table('price') . ' as product_price',
                CatalogStorage::table('in_stock') . ' as in_stock',
                CatalogStorage::table('in_reserve') . ' as in_reserve',
            ])
            ->join(CatalogProduct::table(), CatalogProduct::table('id'), '=', CatalogBasket::table('catalog_product_id'))
            ->leftJoin(CatalogStorage::table(), static function ($join) use ($self) { # TODO: выборку сделать с учетом просроченного резерва
                $catalogStoragePlaceId = $self->catalog_storage_place_id;
                $join->on(CatalogStorage::table('catalog_product_id'), '=', CatalogProduct::table('id'))
                    ->when($catalogStoragePlaceId, function ($query, $catalogStoragePlaceId) {
                        $query->where(CatalogStorage::table('catalog_storage_place_id'), '=', $catalogStoragePlaceId);
                    });
            });
    }

    public function setCounterparty($user_id): self
    {
        $counterparty = self::getCounterparty($user_id);
        $this->counterparty_id = $counterparty->id;
        return $this;
    }

    public static function getCounterparty($user_id): Counterparty
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

    public function counterparty(): BelongsTo
    {
        return $this->BelongsTo(Counterparty::class, 'counterparty_id', 'id');
    }
}
