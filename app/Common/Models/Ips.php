<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogDocument;

/**
 * This is the model class for table "{{%ips}}".
 *
 * @property int $id
 * @property string $ip
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogDocument[] $catalogDocuments
 * @property Comments[] $comments
 * @property IpsHasResource[] $ipsHasResources
 * @property Letters[] $letters
 */
class Ips extends BaseModel
{
    protected $table = 'ax_ips';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogBaskets()
    {
        return $this->hasMany(CatalogBasket::class, ['ips_id' => 'id']);
    }

    public function getCatalogDocuments()
    {
        return $this->hasMany(CatalogDocument::class, ['ips_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['ips_id' => 'id']);
    }

    public function getIpsHasResources()
    {
        return $this->hasMany(IpsHasResource::class, ['ips_id' => 'id']);
    }

    public function getLetters()
    {
        return $this->hasMany(Letters::class, ['ips_id' => 'id']);
    }
}
