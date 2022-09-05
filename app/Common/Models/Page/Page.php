<?php

namespace App\Common\Models\Page;

use App\Common\Models\Render;
use App\Common\Models\Blog\Post;
use App\Common\Models\User\User;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\Blog\PostCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property int $page_type_id
 * @property string|null $type_title
 * @property int|null $render_id
 * @property int|null $gallery_id
 * @property string|null $render_title
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_comments
 * @property int|null $is_watermark
 * @property string $url
 * @property string $alias
 * @property string $title
 * @property string|null $title_short
 * @property string|null $description
 * @property string|null $title_seo
 * @property string|null $description_seo
 * @property string|null $image
 * @property string|null $media
 * @property int|null $hits
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property PageType $pageType
 * @property Render $render
 * @property User $user
 *
 * @property Gallery[] $manyGallery
 * @property Gallery[] $manyGalleryWithImages
 */
class Page extends BaseModel
{
    use SeoSetter, EventSetter;

    protected $table = 'ax_page';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
                    'id' => 'nullable|integer',
                    'render_id' => 'nullable|integer',
                    'page_type_id' => 'nullable|integer',
                    'is_published' => 'nullable|string',
                    'is_favourites' => 'nullable|string',
                    'is_watermark' => 'nullable|string',
                    'is_comments' => 'nullable|string',
                    'alias' => 'nullable|string',
                    'title' => 'required|string',
                    'title_short' => 'nullable|string',
                    'description' => 'nullable|string',
                    'preview_description' => 'nullable|string',
                    'title_seo' => 'nullable|string',
                    'description_seo' => 'nullable|string',
                    'sort' => 'nullable|integer',
                ],
            ][$type] ?? [];
    }

    public static function boot()
    {
        self::creating(static function ($model) {
        });
        self::created(static function ($model) {
        });
        self::updating(static function ($model) {
        });
        self::updated(static function ($model) {
        });
        self::deleting(static function ($model) {
            /* @var $model self */
            $model->deleteImage();
            $model->detachManyGallery();
        });
        self::deleted(static function ($model) {
        });
        parent::boot();
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['id']) || !$model = self::query()->where(self::table() . '.id', $post['id'])->first()) {
            $model = new self();
        }
        $model->page_type_id = $post['page_type_id'] ?? null;
        $model->render_id = $post['render_id'] ?? null;
        $model->is_published = empty($post['is_published']) ? 0 : 1;
        $model->is_favourites = empty($post['is_favourites']) ? 0 : 1;
        $model->is_watermark = empty($post['is_watermark']) ? 0 : 1;
        $model->is_comments = empty($post['is_comments']) ? 0 : 1;
        $model->title_short = $post['title_short'] ?? null;
        $model->description = $post['description'] ?? null;
        $model->sort = $post['sort'] ?? null;
        $model->setTitle($post);
        $model->setAlias($post);
        $model->url = $model->alias;
        if ($model->safe()->getErrors()) {
            return $model;
        }
        $post['images_path'] = $model->setImagesPath();
        if (!empty($post['image'])) {
            $model->setImage($post);
        }
        if (!empty($post['galleries'])) {
            $model->setGalleries($post['galleries']);
        }
        $model->setSeo($post['seo'] ?? []);
        return $model->safe();
    }

    public function render(): BelongsTo
    {
        return $this->belongsTo(Render::class, 'render_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }

    protected function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $catalog = PostCategory::query()
            ->where('alias', $alias)
            ->first();
        if ($catalog) {
            return true;
        }
        $catalog = Post::query()
            ->where('alias', $alias)
            ->first();
        if ($catalog) {
            return true;
        }
        $post = self::query()
            ->where('alias', $alias)
            ->when($id, function ($query, $id) {
                $query->where('id', '!=', $id);
            })->first();
        if ($post) {
            return true;
        }
        return false;
    }
}
