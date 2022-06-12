<?php

namespace App\Common\Models;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\Main\UserSetter;

/**
 * This is the model class for table "{{%letters}}".
 *
 * @property int $id
 * @property string $resource
 * @property int $resource_id
 * @property string $person
 * @property int $person_id
 * @property int|null $ips_id
 * @property string|null $subject
 * @property string|null $text
 * @property int|null $is_viewed
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Ips $ips
 */
class Letters extends BaseModel
{
    use EventSetter, UserSetter;

    protected $table = 'ax_letters';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
            'person' => 'Person',
            'person_id' => 'Person ID',
            'ips_id' => 'Ips ID',
            'subject' => 'Subject',
            'text' => 'Text',
            'is_viewed' => 'Is Viewed',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getIps()
    {
        return $this->hasOne(Ips::class, ['id' => 'ips_id']);
    }
}
