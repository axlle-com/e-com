<?php

namespace App\Common\Models\Widgets;

use App\Common\Models\BaseModel;

/**
* This is the model class for table "ax_widgets_property_group".
*
* @property int $id
* @property string $title
* @property string|null $description
* @property int|null $sort
* @property string|null $image
* @property int|null $created_at
* @property int|null $updated_at
* @property int|null $deleted_at
*
* @property WidgetsProperty[] $widgetsProperties
*/
class WidgetsPropertyGroup extends BaseModel
{
    protected $table = 'ax_widgets_property_group';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];;
    }

    public function attributeLabels()
    {
    return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'sort' => 'Sort',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getWidgetsProperties()
    {
    return $this->hasMany(WidgetsProperty::className(), ['widgets_property_group_id' => 'id']);
    }
}
