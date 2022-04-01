<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%catalog_order}}".
 *
 * @property int $id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket[] $catalogBaskets
 */
class CatalogOrder extends BaseModel
{
    protected $table = 'ax_catalog_order';

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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogBaskets()
    {
        return $this->hasMany(CatalogBasket::class, ['catalog_order_id' => 'id']);
    }
}
