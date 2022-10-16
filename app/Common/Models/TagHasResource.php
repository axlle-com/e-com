<?php

namespace App\Common\Models;

/**
 * This is the model class for table "{{%tag_has_resource}}".
 *
 * @property int $tags_id
 * @property string $resource
 * @property int $resource_id
 *
 * @property Tag $tags
 */
class TagHasResource extends Main\BaseModel
{
    protected $table = 'ax_tag_has_resource';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tags_id']);
    }
}
