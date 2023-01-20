<?php

namespace App\Common\Models\Blog;

use App\Common\Models\Gallery\Gallery;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%post_category}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $category_title
 * @property int|null $category_title_short
 * @property int|null $render_title
 * @property int|null $render_id
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
 * @property Gallery[] $manyGalleryWithImages
 * @property Gallery[] $manyGallery
 * @property PostCategory $category
 * @property PostCategory[] $postCategories
 * @property PostCategory[] $categories
 * @property Render $render
 */
class PostCategory extends BaseModel
{
    use SeoSetter, HasHistory;

    protected static $guardableColumns = [
        'title_seo',
        'description_seo',
    ];

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

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['id']) || !$model = self::withSeo()->where(static::table('id'), $post['id'])->first()) {
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
        $model->sort = $post['sort'] ?? null;
        $model->setTitle($post);
        $model->setAlias($post);
        $model->createdAtSet($post['created_at'] ?? null);
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

    public function deletePosts(): void
    {
        $posts = $this->posts;
        foreach ($posts as $post) {
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

    protected function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $catalog = self::query()->where('alias', $alias)->when($id, function ($query, $id) {
            $query->where('id', '!=', $id);
        })->first();
        if ($catalog) {
            return true;
        }
        $post = Post::query()->where('alias', $alias)->first();
        if ($post) {
            return true;
        }
        $post = Page::query()->where('alias', $alias)->first();
        if ($post) {
            return true;
        }
        return false;
    }
}
