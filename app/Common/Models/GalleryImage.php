<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%gallery_image}}".
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $url
 * @property string|null $title
 * @property string|null $description
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Gallery $gallery
 */
class GalleryImage extends BaseModel
{
    protected $table = 'ax_gallery_image';

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
            'gallery_id' => 'Gallery ID',
            'url' => 'Url',
            'title' => 'Title',
            'description' => 'Description',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getGallery()
    {
        return $this->hasOne(Gallery::class, ['id' => 'gallery_id']);
    }
}
