<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%gallery}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $image
 * @property string|null $url
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property GalleryHasResource[] $galleryHasResources
 * @property GalleryImage[] $galleryImages
 */
class Gallery extends BaseModel
{
    protected $table = 'ax_gallery';

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
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getGalleryHasResources()
    {
        return $this->hasMany(GalleryHasResource::class, ['gallery_id' => 'id']);
    }

    public function getGalleryImages()
    {
        return $this->hasMany(GalleryImage::class, ['gallery_id' => 'id']);
    }
}
