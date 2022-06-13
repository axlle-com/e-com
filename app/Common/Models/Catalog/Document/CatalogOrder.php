<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogCoupon;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\Main\Status;
use App\Common\Models\Main\UserSetter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * This is the model class for table "{{%ax_catalog_order}}".
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
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
 */
class CatalogOrder extends BaseModel implements Status
{
    use EventSetter, UserSetter;

    public bool $isNew = false;
    public bool $isCreateDocument = false;

    private static ?self $_self = null;

    protected $table = 'ax_catalog_order';
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
        if ($this->isCreateDocument) {
            if ($this->status === self::STATUS_NEW) {
                $subject = CatalogDocumentSubject::getByName('reservation');
            }
            if ($this->status === self::STATUS_POST) {
                $subject = CatalogDocumentSubject::getByName('sale');
            }
            $this->load('basketProducts');
            $data = [
                'catalog_document_subject_id' => $subject->id ?? null,
                'user_id' => $this->user_id,
                'status' => self::STATUS_POST,
                'content' => $this->basketProducts->toArray(),
            ];
            $doc = CatalogDocument::createOrUpdate($data);
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

    public static function createOrUpdate(array $post): self
    {
        $id = empty($post['id']) ? null : $post['id'];
        $uuid = empty($post['uuid']) ? null : $post['uuid'];
        $model = null;
        $user = empty($post['user_id']) ? null : $post['user_id'];
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
        $model->catalog_sale_document_id = $post['catalog_document_id'] ?? null;
        $model->catalog_reserve_document_id = $post['catalog_document_id'] ?? null;
        $model->payment_order_id = $post['payment_order_id'] ?? null;
        $model->user_id = $post['user_id'] ?? null;
        if (!$model->safe()->getErrors()) {
            $up = CatalogBasket::query()
                ->where('user_id', $model->user_id)
                ->where('status', '!=', self::STATUS_POST)
                ->update(['catalog_order_id' => $model->id]);
        }
        $model->isCreateDocument = $model->status === self::STATUS_POST;
        return $model;
    }

    public static function getByUser(int $user_id): ?self
    {
        /* @var $self self */
        if (!self::$_self) {
            self::$_self = self::filter()
                ->with(['basketProducts'])
                ->where(self::table('user_id'), $user_id)
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

    public function posting(): self
    {
        DB::beginTransaction();
        if ($this->getErrors()) {
            return $this;
        }
        $this->status = self::STATUS_POST;
        if ($this->safe()->getErrors()) {
            DB::rollBack();
        } else {
            DB::commit();
        }
        return $this;
    }

    public function basketProducts(): HasMany
    {
        return $this->hasMany(CatalogBasket::class, 'catalog_order_id', 'id')
            ->select([
                CatalogBasket::table('*'),
                CatalogProduct::table('title') . ' as product_title',
                CatalogProduct::table('price') . ' as product_price',
            ])
            ->join(CatalogProduct::table(), CatalogProduct::table('id'), '=', CatalogBasket::table('catalog_product_id'));
    }
}
