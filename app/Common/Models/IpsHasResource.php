<?php

namespace App\Common\Models;

/**
 * This is the model class for table "{{%ips_has_resource}}".
 *
 * @property int $ips_id
 * @property int $id
 * @property int $user_id
 * @property string $resource
 * @property int $resource_id
 * @property string $event
 * @property string $body
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property Ips $ips
 */
class IpsHasResource extends Main\BaseModel
{
    protected $table = 'ax_ips_has_resource';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }
}
