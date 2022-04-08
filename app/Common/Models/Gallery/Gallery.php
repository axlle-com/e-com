<?php

namespace App\Common\Models\Gallery;

use App\Common\Models\BaseModel;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\InfoBlock;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%gallery}}".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $sort
 * @property string|null $image
 * @property string|null $url
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogCategory[] $catalogCategories
 * @property GalleryHasResource[] $galleryHasResources
 * @property GalleryImage[] $images
 * @property InfoBlock[] $infoBlocks
 * @property PostCategory[] $postCategories
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

    public static function boot()
    {

        self::creating(static function ($model) {
        });

        self::created(static function ($model) {
        });

        self::updating(static function ($model) {
            /* @var $model self */
//            $model->checkForEmpty();
        });

        self::updated(static function ($model) {
        });

        self::deleting(static function ($model) {
            /* @var $model self */
            $model->deleteImages(); # TODO: пройтись по всем связям обнулить все ссылки
        });

        self::deleted(static function ($model) {
        });
        parent::boot();
    }

    protected function deleteImages(): void
    {
        if (($images = $this->images) && $images->isNotEmpty()) {
            foreach ($images as $image) {
                $image->deleteImage();
            }
        }
    }

    public function galleryHasResources(): HasMany
    {
        return $this->hasMany(GalleryHasResource::class, 'gallery_id', 'id');
    }

    public function getCatalogCategories()
    {
        return $this->hasMany(CatalogCategory::class, ['gallery_id' => 'id']);
    }

    public function getGalleryHasResources()
    {
        return $this->hasMany(GalleryHasResource::class, ['gallery_id' => 'id']);
    }

    public function getInfoBlocks()
    {
        return $this->hasMany(InfoBlock::class, ['gallery_id' => 'id']);
    }

    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::class, ['gallery_id' => 'id']);
    }


    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'gallery_id', 'id')
            ->orderBy('sort')
            ->orderBy('created_at');
    }

    public function checkForEmpty(): void
    {
        if ($this->images->isEmpty()) {
            $this->delete();
        }
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['gallery_id']) || !$model = self::query()->where('id', $post['gallery_id'])->first()) {
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
                $model->setErrors(['gallery_image' => $errors]);
            }
            if ($errors = $image->getErrors()) {
                $model->setErrors(['content' => $errors]);
            } else {
                $model->images = $image->getCollection();
                $model->images->sortBy('sort');
            }
        }
        return $model;
    }
}
