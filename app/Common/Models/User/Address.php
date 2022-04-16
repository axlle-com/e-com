<?php

namespace App\Common\Models\User;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_address".
 *
 * @property int $id
 * @property int $address_type_id
 * @property string $resource
 * @property int $resource_id
 * @property int $is_delivery
 * @property int $index
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string|null $apartment
 * @property string|null $description
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property AddressType $addressType
 */
class Address extends BaseModel
{
    protected $table = 'ax_address';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address_type_id' => 'Address Type ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
            'is_delivery' => 'Is Delivery',
            'index' => 'Index',
            'country' => 'Country',
            'region' => 'Region',
            'city' => 'City',
            'street' => 'Street',
            'house' => 'House',
            'apartment' => 'Apartment',
            'description' => 'Description',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getAddressType()
    {
        return $this->hasOne(AddressType::class, ['id' => 'address_type_id']);
    }
}
