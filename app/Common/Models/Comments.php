<?php

namespace App\Common\Models;


use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property int $id
 * @property string $resource
 * @property int $resource_id
 * @property string $person
 * @property int $person_id
 * @property int|null $comments_id
 * @property int|null $ips_id
 * @property int|null $status
 * @property int|null $is_viewed
 * @property string $text
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Ips $ips
 * @property Comments $comments
 * @property Comments[] $comments0
 */
class Comments extends BaseModel
{
    protected $table = 'ax_comments';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }
}
