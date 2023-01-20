<?php

namespace App\Common\Models;

use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%letter}}".
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
class Letter extends BaseModel
{
    use HasHistory;

    protected $table = 'ax_letter';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public function getIps()
    {
        return $this->hasOne(Ips::class, ['id' => 'ips_id']);
    }
}
