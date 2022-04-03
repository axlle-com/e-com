<?php

namespace App\Common\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%gallery}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $image
 * @property string|null $url
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property GalleryHasResource[] $galleryHasResources
 * @property GalleryImage[] $images
 */
class Gallery extends BaseModel
{
    protected $table = 'ax_gallery';

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

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'gallery_id', 'id');
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['gallery_id']) || !$model = static::query()->where('id', $post['gallery_id'])->first()) {
            $model = new static();
        }
        $model->title = $post['title'];
        if (isset($post['description'])) {
            $model->description = $post['description'];
        }
        if (isset($post['url'])) {
            $model->url = $post['url'];
        }
        if (isset($post['sort'])) {
            $model->sort = $post['sort'];
        }
        if (!empty($post['images'])) {
            $model->safe();
            if ($model->getErrors()) {
                return $model;
            }
            $post['gallery_id'] = $model->id;
            $image = GalleryImage::createOrUpdate($post);
            if ($errors = $image->getErrors()) {
                $model->setErrors($errors);
            }
        }
        return $model;
    }
}
