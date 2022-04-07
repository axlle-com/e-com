<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%info_block}}".
 *
 * @property int $id
 * @property int|null $render_id
 * @property int|null $gallery_id
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_watermark
 * @property int|null $show_image
 * @property string|null $media
 * @property string $alias
 * @property string $title
 * @property string|null $title_short
 * @property string|null $description
 * @property int|null $show_date
 * @property int|null $date_pub
 * @property int|null $date_end
 * @property int|null $control_date_pub
 * @property int|null $control_date_end
 * @property string|null $image
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Gallery $gallery
 * @property Render $render
 * @property InfoBlockHasResource[] $infoBlockHasResources
 */
class InfoBlock extends BaseModel
{
    protected $table = 'ax_info_block';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'render_id' => 'Render ID',
            'gallery_id' => 'Gallery ID',
            'is_published' => 'Is Published',
            'is_favourites' => 'Is Favourites',
            'is_watermark' => 'Is Watermark',
            'show_image' => 'Show Image',
            'media' => 'Media',
            'alias' => 'Alias',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'description' => 'Description',
            'show_date' => 'Show Date',
            'date_pub' => 'Date Pub',
            'date_end' => 'Date End',
            'control_date_pub' => 'Control Date Pub',
            'control_date_end' => 'Control Date End',
            'image' => 'Image',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getGallery()
    {
        return $this->hasOne(Gallery::class, ['id' => 'gallery_id']);
    }

    public function getRender()
    {
        return $this->hasOne(Render::class, ['id' => 'render_id']);
    }

    public function getInfoBlockHasResources()
    {
        return $this->hasMany(InfoBlockHasResource::class, ['info_block_id' => 'id']);
    }
}
