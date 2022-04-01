<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;
use App\Common\Models\User\User;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $render_id
 * @property int|null $category_id
 * @property int|null $gallery_id
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
 */
class Post extends BaseModel
{
    protected $table = 'ax_post';

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

    public function getCategory()
    {
        return $this->hasOne(PostCategory::class, ['id' => 'category_id']);
    }

    public function getRender()
    {
        return $this->hasOne(Render::class, ['id' => 'render_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
