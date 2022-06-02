<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\Status;
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
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'id' => 'integer',
        'uuid' => 'string',
        'user_id' => 'integer',
        'catalog_payment_type_id' => 'integer',
        'catalog_delivery_type_id' => 'integer',
        'catalog_sale_document_id' => 'integer',
        'catalog_reserve_document_id' => 'integer',
        'ips_id' => 'integer',
        'status' => 'integer',
    ];

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
                    'id' => 'nullable|integer',
                    'catalog_payment_type_id' => 'required|integer',
                    'catalog_delivery_type_id' => 'required|integer',
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
        if (empty($post['id']) || !$model = self::filter()->where(self::table('id'), $post['id'])
                ->first()) {
            $model = new self();
        }
        $model->status = $post['status'] ?? self::STATUS_NEW;
        $model->catalog_payment_type_id = $post['catalog_document_subject_id'];
        $model->catalog_delivery_type_id = $post['catalog_document_id'] ?? null;
        $model->catalog_sale_document_id = $post['catalog_document_id'] ?? null;
        $model->catalog_reserve_document_id = $post['catalog_document_id'] ?? null;
        $model->payment_order_id = $post['catalog_document_id'] ?? null;
        $model->user_id = $post['user_id'];
        $model->ips_id = Ips::createOrUpdate($post)->id;
        return $model->safe();
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
}
