<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%post_category}}".
 *
 * @property int $id
 * @property int|null $category_id
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
 * @property PostCategory $category
 * @property PostCategory[] $postCategories
 * @property Render $render
 */
class PostCategory extends BaseModel
{
    protected $table = 'ax_post_category';

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [],
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

    public function getPosts()
    {
        return $this->hasMany(Post::class, ['category_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(PostCategory::class, ['id' => 'category_id']);
    }

    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::class, ['category_id' => 'id']);
    }

    public function getRender()
    {
        return $this->hasOne(Render::class, ['id' => 'render_id']);
    }
}
