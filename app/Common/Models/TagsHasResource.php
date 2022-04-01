<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%tags_has_resource}}".
 *
 * @property int $tags_id
 * @property string $resource
 * @property int $resource_id
 *
 * @property Tags $tags
 */
class TagsHasResource extends BaseModel
{
    protected $table = 'ax_tags_has_resource';

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'tags_id' => 'Tags ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
        ];
    }

    public function getTags()
    {
        return $this->hasOne(Tags::class, ['id' => 'tags_id']);
    }
}
