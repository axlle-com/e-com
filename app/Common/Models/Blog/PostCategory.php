<?php

namespace App\Common\Models\Blog;

use App\Common\Models\BaseModel;
use App\Common\Models\Gallery;
use App\Common\Models\Render;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%post_category}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $render_id
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
                    'render_id' => 'nullable|integer',
                    'is_published' => 'nullable|integer',
                    'is_favourites' => 'nullable|integer',
                    'is_watermark' => 'nullable|integer',
                    'show_image' => 'nullable|integer',
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
        return $this->belongsTo(__CLASS__,'gallery_id','id');
    }

    public function galleryWithImages(): BelongsTo
    {
        return $this->belongsTo(__CLASS__,'gallery_id','id')->with('images');
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

    public function setTitle(array $data): static
    {
        if (empty($data['title'])) {
            $this->setErrors(['title' => 'Обязательно для заполнения']);
        }
        $this->title = $data['title'];
        return $this;
    }

    public function setAlias(array $data): static
    {
        if (empty($data['alias'])) {
            $alias = ax_set_alias($this->title);
            $this->alias = $this->checkAlias($alias);
        } else {
            $this->alias = $this->checkAlias($data['alias']);
        }
        return $this;
    }

    public function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $catalog = static::query()
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

    private function checkAlias(string $alias): string
    {
        $cnt = 1;
        $temp = $alias;
        while ($this->checkAliasAll($temp)) {
            $temp = $alias . '-' . $cnt;
            $cnt++;
        }
        return $temp;
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['id']) || !$model = static::builder()->where('ax_post_category.id', $post['id'])->first()) {
            $model = new static();
        }
        $model->category_id = $post['category_id'] ?? null;
        $model->render_id = $post['render_id'] ?? null;
        $model->is_published = $post['is_published'] ?? 1;
        $model->is_favourites = $post['is_favourites'] ?? 0;
        $model->is_watermark = $post['is_watermark'] ?? 0;
        $model->show_image = $post['show_image'] ?? 1;
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
        if (!empty($post['images'])) {
            $post['gallery_id'] = $model->gallery_id;
            $post['title'] = $model->title;
            $post['images_path'] = $model->getTable() . '/' . $model->alias;
            $gallery = Gallery::createOrUpdate($post);
            if ($errors = $gallery->getErrors()) {
                $model->setErrors(['gallery' => $errors]);
            }
        }
        return $model->safe();
    }

    public static function builder(string $type = 'gallery'): Builder
    {
        $builder = static::query();
        switch ($type) {
            case 'gallery':
                $builder->select([
                    'ax_post_category.*',
                    'ax_gallery.id as gallery_id',
                ])
                    ->join('ax_gallery_has_resource as has', 'has.resource_id', '=', 'ax_post_category.id')
                    ->where('has.resource', (new self)->getTable())
                    ->join('ax_gallery', 'has.gallery_id', '=', 'ax_gallery.id');
                break;
            case '1':
                break;
            case '2':
                break;
        }
        return $builder;
    }
}
