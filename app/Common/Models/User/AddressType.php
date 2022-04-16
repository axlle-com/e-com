<?php

namespace App\Common\Models\User;

use App\Common\Models\Main\BaseModel;

/**
* This is the model class for table "ax_address_type".
*
* @property int $id
* @property string $alias
* @property string $title
* @property string|null $description
* @property string|null $image
* @property int|null $created_at
* @property int|null $updated_at
* @property int|null $deleted_at
*
* @property Address[] $addresses
*/
class AddressType extends BaseModel
{
    protected $table = 'ax_address_type';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
                    'id' => 'ID',
                    'alias' => 'Alias',
                    'title' => 'Title',
                    'description' => 'Description',
                    'image' => 'Image',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                    'deleted_at' => 'Deleted At',
                ];
    }

    public function getAddresses()
    {
    return $this->hasMany(Address::class, ['address_type_id' => 'id']);
    }
}
