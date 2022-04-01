<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;
use App\Common\Models\Ips;

/**
 * This is the model class for table "{{%catalog_comments}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $comments_id
 * @property int|null $ips_id
 * @property string $resource
 * @property int $resource_id
 * @property int|null $status
 * @property int|null $is_viewed
 * @property string $text
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProduct $product
 * @property Ips $ips
 * @property CatalogComments $comments
 * @property CatalogComments[] $catalogComments
 */
class CatalogComments extends BaseModel
{
    protected $table = 'ax_catalog_comments';

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
            'product_id' => 'Product ID',
            'comments_id' => 'Comments ID',
            'ips_id' => 'Ips ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
            'status' => 'Status',
            'is_viewed' => 'Is Viewed',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(CatalogProduct::class, ['id' => 'product_id']);
    }

    public function getIps()
    {
        return $this->hasOne(Ips::class, ['id' => 'ips_id']);
    }

    public function getComments()
    {
        return $this->hasOne(CatalogComments::class, ['id' => 'comments_id']);
    }

    public function getCatalogComments()
    {
        return $this->hasMany(CatalogComments::class, ['comments_id' => 'id']);
    }
}
