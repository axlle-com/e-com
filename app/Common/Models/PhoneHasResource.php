<?php

namespace App\Common\Models;

/**
 * This is the model class for table "{{%phone_has_resource}}".
 *
 * @property int $phone_id
 * @property string $resource
 * @property int $resource_id
 *
 * @property Phone $phone
 */
class PhoneHasResource extends Main\BaseModel
{
    protected $table = 'ax_phone_has_resource';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'phone_id' => 'Phone ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
        ];
    }

    public function getPhone()
    {
        return $this->hasOne(Phone::class, ['id' => 'phone_id']);
    }
}
