<?php

namespace App\Common\Models\Gallery;

use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Main\BaseModel;
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
 * @property PostCategory[] $postCategories
 */
class Gallery extends BaseModel
{
    protected $table = 'ax_gallery';

    public static function pivot(string $column = ''): string
    {
        return $column
            ? 'ax_gallery_has_resource.' . trim($column, '.')
            : 'ax_gallery_has_resource';
    }

    public static function boot()
    {

        self::creating(static function ($model) {
        });

        self::created(static function ($model) {
        });

        self::updating(static function ($model) {
            /* @var $model self */
            $model->checkForEmpty();
        });

        self::updated(static function ($model) {
        });

        self::deleting(static function ($model) {
            /* @var $model self */
            $model->deleteImages();
        });

        self::deleted(static function ($model) {
        });
        parent::boot();
    }

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['gallery_id']) || !$model = self::query()->where('id', $post['gallery_id'])->first()) {
            $model = new self();
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
            if ($errors = $image->getErrors()) {
                $model->setErrors($errors);
            } else {
                $model->images = $image->getCollection();
                $model->images->sortBy('sort');
            }
        }
        return $model;
    }

    public function checkForEmpty(): void
    {
        if (!count($this->images)) {
            $this->delete();
        }
    }

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'gallery_id', 'id')->orderBy('sort')->orderBy('created_at');
    }

    protected function deleteImages(): void
    {
        $this->images()->delete();
    }
}
