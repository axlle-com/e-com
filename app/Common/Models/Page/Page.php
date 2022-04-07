<?php

namespace App\Common\Models\Page;

use App\Common\Models\BaseModel;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Render;
use App\Common\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property int $user_id
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
 * @property Gallery $gallery
 * @property Gallery $galleryWithImages
 */
class Page extends BaseModel
{
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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'page_type_id' => 'Page Type ID',
            'render_id' => 'Render ID',
            'is_published' => 'Is Published',
            'is_favourites' => 'Is Favourites',
            'is_comments' => 'Is Comments',
            'is_watermark' => 'Is Watermark',
            'url' => 'Url',
            'alias' => 'Alias',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'description' => 'Description',
            'title_seo' => 'Title Seo',
            'description_seo' => 'Description Seo',
            'image' => 'Image',
            'media' => 'Media',
            'hits' => 'Hits',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getPageType()
    {
        return $this->hasOne(PageType::className(), ['id' => 'page_type_id']);
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

    public static function createOrUpdate(array $post): static
    {
        /* @var $gallery Gallery */
        if (empty($post['id']) || !$model = self::builder()->_gallery()->where(self::table() . '.id', $post['id'])->first()) {
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
