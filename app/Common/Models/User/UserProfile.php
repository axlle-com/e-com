<?php

namespace App\Common\Models\User;

use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogPaymentType;
use App\Common\Models\Main\BaseModel;

/**
* This is the model class for table "ax_user_profile".
*
* @property int $id
* @property int $user_id
* @property int|null $catalog_delivery_type_id
* @property int|null $catalog_payment_type_id
* @property string $title
* @property string|null $description
* @property string|null $image
* @property int|null $created_at
* @property int|null $updated_at
* @property int|null $deleted_at
*
* @property CatalogDeliveryType $catalogDeliveryType
* @property CatalogPaymentType $catalogPaymentType
* @property User $user
*/
class UserProfile extends BaseModel
{
    protected $table = 'ax_user_profile';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
                    'id' => 'ID',
                    'user_id' => 'User ID',
                    'catalog_delivery_type_id' => 'Catalog Delivery Type ID',
                    'catalog_payment_type_id' => 'Catalog Payment Type ID',
                    'title' => 'Title',
                    'description' => 'Description',
                    'image' => 'Image',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                    'deleted_at' => 'Deleted At',
                ];
    }

    public function getCatalogDeliveryType()
    {
    return $this->hasOne(CatalogDeliveryType::class, ['id' => 'catalog_delivery_type_id']);
    }

    public function getCatalogPaymentType()
    {
    return $this->hasOne(CatalogPaymentType::class, ['id' => 'catalog_payment_type_id']);
    }

    public function getUser()
    {
    return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
