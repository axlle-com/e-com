<?php

namespace App\Common\Models\Blog;

use App\Common\Models\BaseModel;
use App\Common\Models\Gallery;
use App\Common\Models\GalleryImage;
use App\Common\Models\Render;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%post_category}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $category_title
 * @property string|null $category_title_short
 * @property int|null $render_id
 * @property string $render_title
 * @property int|null $gallery_id
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_watermark
 * @property string|null $image
 * @property int|null $show_image
 * @property string $url
 * @property string $alias
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
 * @property Post[] $posts
 * @property Gallery $gallery
 * @property Gallery $galleryWithImages
 * @property PostCategory $category
 * @property PostCategory[] $postCategories
 * @property Render $render
 */
class PostCategory extends BaseModel
{
    protected $table = 'ax_post_category';

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

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'render_id' => 'Render ID',
            'gallery_id' => 'Gallery ID',
            'is_published' => 'Is Published',
            'is_favourites' => 'Is Favourites',
            'is_watermark' => 'Is Watermark',
            'image' => 'Image',
            'show_image' => 'Show Image',
            'url' => 'Url',
            'alias' => 'Alias',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'description' => 'Description',
            'preview_description' => 'Preview Description',
            'title_seo' => 'Title Seo',
            'description_seo' => 'Description Seo',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    }

    public function galleryWithImages(): BelongsTo
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id')->with('images');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'category_id', 'id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(__CLASS__, 'category_id', 'id');
    }

    public function render(): BelongsTo
    {
        return $this->belongsTo(Render::class, 'render_id', 'id');
    }

    protected function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $catalog = self::query()
            ->where('alias', $alias)
            ->when($id, function ($query, $id) {
                $query->where('id', '!=', $id);
            })->first();
        if ($catalog) {
            return true;
        }
        $post = Post::query()
            ->where('alias', $alias)
            ->first();
        if ($post) {
            return true;
        }
        return false;
    }

    public static function createOrUpdate(array $post): static
    {
        /* @var $gallery Gallery */
        if (empty($post['id']) || !$model = self::query()->where('id', $post['id'])->first()) {
            $model = new self();
        }
        $model->category_id = $post['category_id'] ?? null;
        $model->render_id = $post['render_id'] ?? null;
        $model->is_published = empty($post['is_published']) ? 0 : 1;
        $model->is_favourites = empty($post['is_favourites']) ? 0 : 1;
        $model->is_watermark = empty($post['is_watermark']) ? 0 : 1;
        $model->show_image = empty($post['show_image']) ? 0 : 1;
        $model->title_short = $post['title_short'] ?? null;
        $model->description = $post['description'] ?? null;
        $model->preview_description = $post['preview_description'] ?? null;
        $model->title_seo = $post['title_seo'] ?? null;
        $model->description_seo = $post['description_seo'] ?? null;
        $model->sort = $post['sort'] ?? null;
        $model->setTitle($post);
        $model->setAlias($post);
        $model->createdAtSet($post['created_at']);
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
            $model->gallery_id = $gallery->id;
        }
        return $model->safe();
    }

    public static function builder(string $type = 'index'): Builder
    {
        $builder = static::query();
        switch ($type) {
            case 'category':
                $builder->select([
                    'ax_post_category.*',
                    'par.title as category_title',
                    'par.title_short as category_title_short',
                    'ren.title as render_title',
                ])
                    ->leftJoin('ax_post_category as par', 'ax_post_category.category_id', '=', 'par.id')
                    ->leftJoin('ax_render as ren', 'ax_post_category.render_id', '=', 'ren.id');
                break;
            case 'gallery1':
                break;
            case 'gallery2':
                break;
        }
        return $builder;
    }
}
