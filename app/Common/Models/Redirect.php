<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%redirect}}".
 *
 * @property int $id
 * @property string $url
 * @property string $url_old
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class Redirect extends BaseModel
{
    protected $table = 'ax_redirect';

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
            'url' => 'Url',
            'url_old' => 'Url Old',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
