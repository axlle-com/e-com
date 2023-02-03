<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Gallery\HasGallery;
use App\Common\Models\Gallery\HasGalleryImage;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Render;
use App\Common\Models\Url\HasUrl;
use App\Common\Models\User\User;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * This is the model class for table "{{%post_category}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $user_id
 * @property int|null $category_title
 * @property int|null $category_title_short
 * @property int|null $render_title
 * @property int|null $render_id
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_watermark
 * @property string|null $image
 * @property int|null $show_image
 * @property string $title
 * @property string|null $title_short
 * @property string|null $description
 * @property string|null $preview_description
 * @property string|null $title_seo
 * @property string|null $description_seo
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Collection<Post> $posts
 * @property PostCategory $category
 * @property Collection<PostCategory> $postCategories
 * @property Collection<PostCategory> $categories
 * @property Render $render
 */
class PostCategory extends BaseModel
{
    use SeoSetter;
    use HasHistory;
    use HasUrl;
    use HasGallery;
    use HasGalleryImage;

    protected static $guardableColumns = [
        'title_seo',
        'description_seo',
    ];

    protected $table = 'ax_post_category';
    protected $fillable = [
        'user_id',
        'render_id',
        'is_published',
        'is_favourites',
        'is_watermark',
        'title',
        'title_short',
        'description',
        'image',
        'sort',
        'deleted_at',
    ];
    protected $attributes = [
        'category_id' => null,
        'render_id' => null,
        'is_published' => 0,
        'is_favourites' => 0,
        'is_watermark' => 0,
        'show_image' => 0,
        'title_short' => null,
        'description' => null,
        'preview_description' => null,
        'sort' => null,
    ];

    protected static function boot()
    {
        self::creating(static function(self $model) {
            if( !$model->user_id) {
                $model->setUserId();
            }
        });
        self::created(static function($model) { });
        self::updating(static function($model) { });
        self::updated(static function($model) { });
        self::deleting(static function($model) { });
        self::deleted(static function($model) { });
        parent::boot();
    }

    public static function rules(string $type = 'create'): array
    {
        return [
            'create' => [
                'id' => 'nullable|integer',
                'category_id' => 'nullable|integer',
                'gallery_id' => 'nullable|integer',
                'render_id' => 'nullable|integer',
                'is_published' => 'nullable|string',
                'is_favourites' => 'nullable|string',
                'is_watermark' => 'nullable|string',
                'show_image' => 'nullable|string',
                'title' => 'required|string',
                'title_short' => 'nullable|string',
                'description' => 'nullable|string',
                'preview_description' => 'nullable|string',
                'title_seo' => 'nullable|string',
                'description_seo' => 'nullable|string',
                'sort' => 'nullable|integer',
                'created_at' => 'nullable|string',
            ],
            'filter' => [
                'category' => 'nullable|integer',
                'render' => 'nullable|integer',
                'published' => 'nullable|integer',
                'favourites' => 'nullable|integer',
                'title' => 'nullable|string',
                'description' => 'nullable|string',
            ],
        ][$type] ?? [];
    }

    public function deletePosts(): void
    {
        $posts = $this->posts;
        foreach($posts as $post) {
            $post->delete();
        }
    }

    public function deleteCategories(): void
    {
        $this->categories()->delete();
    }

    public function categories(): HasMany
    {
        return $this->hasMany(__CLASS__, 'category_id', 'id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'category_id', 'id');
    }

    public function render(): BelongsTo
    {
        return $this->belongsTo(Render::class, 'render_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }

    public function setUserId(?int $id = null): static
    {
        if($id) {
            $this->user_id = $id;
        } else {
            $user = UserWeb::auth() ?: UserRest::auth() ?: UserApp::auth();
            $this->user_id = $user->id ?? null;
        }

        return $this;
    }

}
