<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%ips_has_resource}}".
 *
 * @property int $ips_id
 * @property string $resource
 * @property int $resource_id
 *
 * @property Ips $ips
 */
class IpsHasResource extends BaseModel
{
    protected $table = 'ax_ips_has_resource';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'ips_id' => 'Ips ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
        ];
    }

    public function getIps()
    {
        return $this->hasOne(Ips::class, ['id' => 'ips_id']);
    }
}
