<?php

namespace App\Common\Models;


use App\Common\Models\BaseModel;

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

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
            'person' => 'Person',
            'person_id' => 'Person ID',
            'comments_id' => 'Comments ID',
            'ips_id' => 'Ips ID',
            'status' => 'Status',
            'is_viewed' => 'Is Viewed',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getIps()
    {
        return $this->hasOne(Ips::class, ['id' => 'ips_id']);
    }

    public function getComments()
    {
        return $this->hasOne(Comments::class, ['id' => 'comments_id']);
    }

    public function getComments0()
    {
        return $this->hasMany(Comments::class, ['comments_id' => 'id']);
    }
}
