<?php

namespace App\Common\Models\Gallery;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%gallery_has_resource}}".
 *
 * @property int $gallery_id
 * @property string $resource
 * @property int $resource_id
 *
 * @property Gallery $gallery
 */
class GalleryHasResource extends BaseModel
{
    protected $table = 'ax_gallery_has_resource';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'gallery_id' => 'Gallery ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
        ];
    }

    public function getGallery()
    {
        return $this->hasOne(Gallery::class, ['id' => 'gallery_id']);
    }
}
