<?php

namespace App\Common\Models\Widgets;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%widgets_content}}".
 *
 * @property int $id
 * @property int $widgets_id
 * @property string $title
 * @property string|null $title_short
 * @property string|null $description
 * @property string|null $image
 * @property int|null $sort
 * @property int|null $show_image
 * @property string|null $media
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Widgets $widgets
 */
class WidgetsContent extends BaseModel
{
    protected $table = '{{%widgets_content}}';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'widgets_id' => 'Widgets ID',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'description' => 'Description',
            'image' => 'Image',
            'sort' => 'Sort',
            'show_image' => 'Show Image',
            'media' => 'Media',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getWidgets()
    {
        return $this->hasOne(Widgets::class, ['id' => 'widgets_id']);
    }
}
