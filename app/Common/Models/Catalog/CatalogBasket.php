<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;
use App\Common\Models\Ips;
use App\Common\Models\User\User;

/**
 * This is the model class for table "{{%catalog_basket}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int|null $catalog_order_id
 * @property int|null $currency_id
 * @property int|null $ips_id
 * @property int|null $quantity
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogOrder $catalogOrder
 * @property CatalogProduct $product
 * @property Currency $currency
 * @property Ips $ips
 * @property User $user
 */
class CatalogBasket extends BaseModel
{
    protected $table = 'ax_catalog_basket';

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [],
            ][$type] ?? [];
    }


    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'catalog_order_id' => 'Catalog Order ID',
            'currency_id' => 'Currency ID',
            'ips_id' => 'Ips ID',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogOrder()
    {
        return $this->hasOne(CatalogOrder::class, ['id' => 'catalog_order_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(CatalogProduct::class, ['id' => 'product_id']);
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    public function getIps()
    {
        return $this->hasOne(Ips::class, ['id' => 'ips_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
