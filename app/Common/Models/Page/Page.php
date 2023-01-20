<?php

namespace App\Common\Models\Page;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Gallery\HasGallery;
use App\Common\Models\Gallery\HasGalleryImage;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Render;
use App\Common\Models\Url\HasUrl;
use App\Common\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
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
 * @property string|null $image
 * @property string|null $media
 * @property int|null $hits
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Render $render
 * @property User $user
 *
 * @property Collection<Gallery> $manyGallery
 * @property Collection<Gallery> $manyGalleryWithImages
 */
class Page extends BaseModel
{
    use SeoSetter;
    use HasHistory;
    use HasGalleryImage;
    use HasGallery;
    use HasUrl;

    protected $table = 'ax_page';
    protected $attributes = [
        'render_id' => null,
        'is_published' => 0,
        'is_favourites' => 0,
        'is_watermark' => 0,
        'is_comments' => 0,
        'title_short' => null,
        'description' => null,
        'sort' => null,
    ];

    public static function boot()
    {
        self::creating(static function ($model) {});
        self::created(static function ($model) {});
        self::updating(static function ($model) {});
        self::updated(static function ($model) {});
        self::deleting(static function ($model) {
            /** @var $model self */
            $model->deleteImage();
            $model->detachManyGallery();
        });
        self::deleted(static function ($model) {});
        parent::boot();
    }

    public static function rules(string $type = 'create'): array
    {
        return [
            'create' => [
                'id' => 'nullable|integer',
                'render_id' => 'nullable|integer',
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

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['id']) || !$model = self::query()->where(self::table() . '.id', $post['id'])->first()) {
            $model = new self();
        }
        return $model->loadModel($post)->safe();
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
        if (PostCategory::query()->where('alias', $alias)->first()) {
            return true;
        }
        if (Post::query()->where('alias', $alias)->first()) {
            return true;
        }
        $id = $this->id;
        $self = self::query()->where('alias', $alias)->when($id, function ($query, $id) {
            $query->where('id', '!=', $id);
        })->first();
        if ($self) {
            return true;
        }
        return false;
    }
}
