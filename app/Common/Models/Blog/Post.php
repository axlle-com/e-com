<?php

namespace App\Common\Models\Blog;

use App\Common\Models\BaseModel;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $gallery_id
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
 * @property string $url
 * @property string $alias
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
 * @property Gallery[] $galleryWithImages
 * @property Gallery[] $gallery
 */
class Post extends BaseModel
{
    protected $table = 'ax_post';

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
            $model->deleteImage(); # TODO: пройтись по всем связям
        });
        self::deleted(static function ($model) {
        });
        parent::boot();
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'render_id' => 'Render ID',
            'category_id' => 'Category ID',
            'gallery_id' => 'Gallery ID',
            'is_published' => 'Is Published',
            'is_favourites' => 'Is Favourites',
            'is_comments' => 'Is Comments',
            'is_image_post' => 'Is Image Post',
            'is_image_category' => 'Is Image Category',
            'is_watermark' => 'Is Watermark',
            'media' => 'Media',
            'url' => 'Url',
            'alias' => 'Alias',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'preview_description' => 'Preview Description',
            'description' => 'Description',
            'title_seo' => 'Title Seo',
            'description_seo' => 'Description Seo',
            'show_date' => 'Show Date',
            'date_pub' => 'Date Pub',
            'date_end' => 'Date End',
            'control_date_pub' => 'Control Date Pub',
            'control_date_end' => 'Control Date End',
            'image' => 'Image',
            'hits' => 'Hits',
            'sort' => 'Sort',
            'stars' => 'Stars',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
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

    public function gallery(): BelongsToMany
    {
        return $this->belongsToMany(
            Gallery::class,
            'ax_gallery_has_resource',
            'resource_id',
            'gallery_id'
        );
    }

    public function galleryWithImages(): BelongsToMany
    {
        return $this->belongsToMany(
            Gallery::class,
            'ax_gallery_has_resource',
            'resource_id',
            'gallery_id'
        )->with('images');
    }

    protected function deleteGallery(): void
    {
        if (($gallery = $this->gallery)) {
            $gallery->delete();
        }
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
        $catalog = Page::query()
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

    public static function createOrUpdate(array $post): static
    {
        /* @var $gallery Gallery */
        if (empty($post['id']) || !$model = self::builder()->_gallery()->where(self::table() . '.id', $post['id'])->first()) {
            $model = new self();
        }
        $model->category_id = $post['category_id'] ?? null;
        $model->render_id = $post['render_id'] ?? null;
        $model->is_published = empty($post['is_published']) ? 0 : 1;
        $model->is_favourites = empty($post['is_favourites']) ? 0 : 1;
        $model->is_watermark = empty($post['is_watermark']) ? 0 : 1;
        $model->is_comments = empty($post['is_comments']) ? 0 : 1;
        $model->is_image_post = empty($post['is_image_post']) ? 0 : 1;
        $model->is_image_category = empty($post['is_image_category']) ? 0 : 1;
        $model->date_pub = strtotime($post['date_pub']);
        $model->date_end = strtotime($post['date_end']);
        $model->control_date_pub = empty($post['control_date_pub']) ? 0 : 1;
        $model->control_date_end = empty($post['control_date_end']) ? 0 : 1;
        $model->title_short = $post['title_short'] ?? null;
        $model->description = $post['description'] ?? null;
        $model->preview_description = $post['preview_description'] ?? null;
        $model->title_seo = $post['title_seo'] ?? null;
        $model->description_seo = $post['description_seo'] ?? null;
        $model->sort = $post['sort'] ?? null;
        $model->setTitle($post);
        $model->setAlias($post);
        $model->url = $model->alias;
        $post['images_path'] = $model->setImagesPath();
        if (!empty($post['image'])) {
            if ($model->image) {
                unlink(public_path($model->image));
            }
            if ($urlImage = GalleryImage::uploadSingleImage($post)) {
                $model->image = $urlImage;
            }
        }
        if (!empty($post['images'])) {
            $post['gallery_id'] = $model->gallery_id;
            $post['title'] = $model->title;
            $gallery = Gallery::createOrUpdate($post);
            if ($errors = $gallery->getErrors()) {
                $model->setErrors(['gallery' => $errors]);
            }
        }
        unset($model->gallery_id);
        $model->user_id = $post['user_id'];
        if ($model->safe()->getErrors()) {
            return $model;
        }
        if (isset($gallery) && !$gallery->getErrors()) {
            $model->gallery()?->sync([($gallery->id ?? null) => ['resource' => $model->getTable()]]);
        }
        return $model;
    }

}
