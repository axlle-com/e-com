<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\Status;
use App\Common\Models\User\User;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Facades\DB;

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
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class CatalogOrder extends BaseModel implements Status
{
    protected $table = 'ax_catalog_order';
    protected $fillable = [
        'id',
        'uuid',
        'user_id',
        'catalog_payment_type_id',
        'catalog_delivery_type_id',
        'catalog_sale_document_id',
        'catalog_reserve_document_id',
        'ips_id',
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

    public static function boot()
    {
        self::creating(static function ($model) {
        });
        self::created(static function ($model) {
        });
        self::updating(static function ($model) {
        });
        self::updated(static function ($model) {
        });
        self::deleting(static function ($model) {
        });
        self::deleted(static function ($model) {
        });
        self::saving(static function ($model) {
        });
        self::saved(static function ($model) {
            /* @var $model self */
            $model->createDocument();
        });
        parent::boot();
    }

    public function createDocument(): void
    {
        $user = UserWeb::auth();
        $data = [];
        if ($this->status === self::STATUS_NEW) {
            $subject = CatalogDocumentSubject::getByName('reservation');
        }
        if ($this->status === self::STATUS_POST) {
            $subject = CatalogDocumentSubject::getByName('sale');
        }
        $data = [
            'catalog_document_subject_id' => $subject->id ?? null,
            'user_id' => $user->id,
            'ip' => $user->ip,
            'status' => 1,
            'content' => [
                [
                    'catalog_product_id' => $this->id,
                    'price_out' => $this->price,
                    'quantity' => $this->quantity ?: 1,
                ]
            ],
        ];
        $doc = CatalogDocument::createOrUpdate($data);
        if ($err = $doc->getErrors()) {
            $this->setErrors($err);
        } elseif ($err = $doc->posting()->getErrors()) {
            $this->setErrors($err);
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

    public static function createOrUpdate(User $user): self
    {

        $data = $user->order->toArray();
        if (empty($data['id']) || !$model = self::filter()->where(self::table('id'), $data['id'])
                ->first()) {
            $model = new self();
        }
        $model->status = $data['status'] ?? self::STATUS_NEW;
        $model->catalog_payment_type_id = $data['catalog_payment_type_id'] ?? null;
        $model->catalog_delivery_type_id = $data['catalog_delivery_type_id'] ?? null;
        $model->catalog_sale_document_id = $data['catalog_document_id'] ?? null;
        $model->catalog_reserve_document_id = $data['catalog_document_id'] ?? null;
        $model->payment_order_id = $data['payment_order_id'] ?? null;
        $model->user_id = $user->id;
        $model->ips_id = Ips::createOrUpdate(['ip' => $user->ip])->id;
        return $model->safe();
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
}
