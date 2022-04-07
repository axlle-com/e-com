<?php

namespace App\Common\Models\Gallery;

use App\Common\Models\BaseModel;
use Illuminate\Support\Str;
use RuntimeException;

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
    private static array $types = [
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_JPEG => 'jpeg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_BMP => 'bmp',
        IMAGETYPE_WBMP => 'wbmp',
        IMAGETYPE_WEBP => 'webp',
    ];
    protected $table = 'ax_gallery_image';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
                'delete' => [
                    'id' => 'required|integer',
                ],
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

    public static function getType(int $type): ?string
    {
        return self::$types[$type] ?? null;
    }

    public static function createOrUpdate(array $post): static
    {
        $errors = [];
        $dir = self::createPath($post);
        foreach ($post['images'] as $image) {
            /* @var $model self */
            if (($id = $image['id'] ?? null) && ($model = self::query()->where('id', $id)->first())) {
                if ($image['title'] ?? null) {
                    $model->title = $image['title'];
                }
                if ($image['description'] ?? null) {
                    $model->description = $image['description'];
                }
                if ($image['sort'] ?? null) {
                    $model->sort = $image['sort'];
                }
                if ($error = $model->safe()->getErrors()) {
                    $errors[] = $error;
                }
            } elseif ($types = self::getType(exif_imagetype($image['file']))) {
                $url = Str::random(40) . '.' . $types;
                $filename = public_path() . '/' . $dir . '/' . $url;
                if (move_uploaded_file($image['file'], $filename)) {
                    $model = new static();
                    $model->title = $post['title'];
                    $model->gallery_id = $post['gallery_id'];
                    $model->description = $image['description'];
                    $model->sort = $image['sort'];
                    $model->url = '/' . $dir . '/' . $url;
                    if ($error = $model->safe()->getErrors()) {
                        $errors[] = $error;
                    }
                }
            }
        }
        return self::sendErrors($errors);
    }

    public static function uploadSingleImage(array $post): ?string
    {
        $post['dir'] = self::createPath($post);
        return self::uploadImage($post);
    }

    public static function uploadImage(array $post): ?string
    {
        if ($types = self::getType(exif_imagetype($post['image']))) {
            $url = Str::random(40) . '.' . $types;
            $filename = public_path() . '/' . $post['dir'] . '/' . $url;
            if (move_uploaded_file($post['image'], $filename)) {
                return '/' . $post['dir'] . '/' . $url;
            }
        }
        return null;
    }

    public static function createPath(array $post): string
    {
        $dir = 'upload/' . $post['images_path'];
        if (!file_exists($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }
        return $dir;
    }
}
