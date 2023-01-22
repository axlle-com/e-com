<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Gallery\HasGallery;
use App\Common\Models\Gallery\HasGalleryImage;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Render;
use App\Common\Models\Url\HasUrl;
use App\Common\Models\User\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $render_id
 * @property string|null $render_title
 * @property int|null $category_id
 * @property string|null $category_title
 * @property string|null $category_title_short
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_comments
 * @property int|null $is_image_post
 * @property int|null $is_image_category
 * @property int|null $is_watermark
 * @property string|null $media
 * @property string $title
 * @property string|null $title_short
 * @property string|null $preview_description
 * @property string|null $description
 * @property string|null $title_seo
 * @property string|null $description_seo
 * @property int|null $show_date
 * @property int|null $date_pub
 * @property int|null $date_end
 * @property int|null $control_date_pub
 * @property int|null $control_date_end
 * @property string|null $image
 * @property int|null $hits
 * @property int|null $sort
 * @property float|null $stars
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property PostCategory $category
 * @property Render $render
 * @property User $user
 */
class Post extends BaseModel
{
    use SeoSetter;
    use HasHistory;
    use HasUrl;
    use HasGallery;
    use HasGalleryImage;

    protected $table = 'ax_post';
    protected $fillable = [
        'user_id',
        'render_id',
        'category_id',
        'is_published',
        'is_favourites',
        'is_comments',
        'is_image_post',
        'is_image_category',
        'is_watermark',
        'title',
        'title_short',
        'description',
        'preview_description',
        'show_date',
        'date_pub',
        'date_end',
        'control_date_pub',
        'control_date_end',
        'image',
        'media',
        'hits',
        'sort',
        'stars',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $attributes = [
        'render_id' => null,
        'category_id' => null,
        'is_published' => 0,
        'is_favourites' => 0,
        'is_comments' => 0,
        'is_image_post' => 0,
        'is_image_category' => 0,
        'is_watermark' => 0,
        'title_short' => null,
        'description' => null,
        'preview_description' => null,
        'show_date' => 0,
        'control_date_pub' => 0,
        'control_date_end' => 0,
        'image' => null,
        'media' => null,
        'hits' => null,
        'sort' => null,
        'stars' => null,
    ];
    protected static $guardableColumns = [
        'title_seo',
        'description_seo',
        'alias',
        'url',
    ];

    public static function rules(string $type = 'create'): array
    {
        return [
            'create' => [
                'id' => 'nullable|integer',
                'category_id' => 'nullable|integer',
                'render_id' => 'nullable|integer',
                'is_published' => 'nullable|string',
                'is_favourites' => 'nullable|string',
                'is_watermark' => 'nullable|string',
                'is_comments' => 'nullable|string',
                'is_image_post' => 'nullable|string',
                'is_image_category' => 'nullable|string',
                'show_date' => 'nullable|string',
                'control_date_pub' => 'nullable|string',
                'control_date_end' => 'nullable|string',
                'show_image' => 'nullable|string',
//                'title' => 'required|string|unique:' . self::table(),
//                'title' => [
//                    'required',
//                    Rule::unique('users')->ignore($user->id),
//                ],
//                'title_short' => 'nullable|string',
                'description' => 'nullable|string',
                'preview_description' => 'nullable|string',
                'title_seo' => 'nullable|string',
                'description_seo' => 'nullable|string',
                'sort' => 'nullable|integer',
            ],
        ][$type] ?? [];
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

    protected function datePub(): Attribute
    {
        return Attribute::make(get: static fn ($value) => date($value), set: static fn ($value) => strtotime($value),);
    }

    protected function dateEnd(): Attribute
    {
        return Attribute::make(get: static fn ($value) => date($value), set: static fn ($value) => strtotime($value),);
    }
}
