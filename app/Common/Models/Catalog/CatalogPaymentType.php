<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;

/**
* This is the model class for table "ax_catalog_payment_type".
*
* @property int $id
* @property string $title
* @property string|null $description
* @property string|null $image
* @property int|null $created_at
* @property int|null $updated_at
* @property int|null $deleted_at
*
* @property CatalogDocument[] $catalogDocuments
* @property UserProfile[] $userProfiles
*/
class CatalogPaymentType extends BaseModel
{
    protected $table = 'ax_catalog_payment_type';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
                    'id' => 'ID',
                    'title' => 'Title',
                    'description' => 'Description',
                    'image' => 'Image',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                    'deleted_at' => 'Deleted At',
                ];
    }

    public function getCatalogDocuments()
    {
    return $this->hasMany(CatalogDocument::class, ['catalog_payment_type_id' => 'id']);
    }

    public function getUserProfiles()
    {
    return $this->hasMany(UserProfile::class, ['catalog_payment_type_id' => 'id']);
    }
}
