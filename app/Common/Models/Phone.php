<?php

namespace App\Common\Models;

/**
 * This is the model class for table "{{%phone}}".
 *
 * @property int $id
 * @property string $number
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property PhoneHasResource[] $phoneHasResources
 */
class Phone extends Main\BaseModel
{
    protected $table = 'ax_phone';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getPhoneHasResources()
    {
        return $this->hasMany(PhoneHasResource::class, ['phone_id' => 'id']);
    }
}
