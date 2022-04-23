<?php

namespace App\Common\Models\Widgets;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_widgets_property".
 *
 * @property int $id
 * @property int $widgets_property_type_id
 * @property string $title
 * @property string|null $description
 * @property int|null $sort
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property WidgetsHasValueDecimal[] $widgetsHasValueDecimals
 * @property WidgetsHasValueInt[] $widgetsHasValueInts
 * @property WidgetsHasValueText[] $widgetsHasValueTexts
 * @property WidgetsHasValueVarchar[] $widgetsHasValueVarchars
 * @property WidgetsPropertyType $widgetsPropertyType
 * @property WidgetsPropertyGroup[] $widgetsPropertyGroups
 */
class WidgetsProperty extends BaseModel
{
    protected $table = 'ax_widgets_property';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
    return [
            'id' => 'ID',
            'widgets_property_group_id' => 'Widgets Property Group ID',
            'title' => 'Title',
            'description' => 'Description',
            'sort' => 'Sort',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getWidgetsHasValueDecimals()
    {
        return $this->hasMany(WidgetsHasValueDecimal::className(), ['widgets_property_id' => 'id']);
    }

    public function getWidgetsHasValueInts()
    {
        return $this->hasMany(WidgetsHasValueInt::className(), ['widgets_property_id' => 'id']);
    }

    public function getWidgetsHasValueTexts()
    {
        return $this->hasMany(WidgetsHasValueText::className(), ['widgets_property_id' => 'id']);
    }

    public function getWidgetsHasValueVarchars()
    {
        return $this->hasMany(WidgetsHasValueVarchar::className(), ['widgets_property_id' => 'id']);
    }

    public function getWidgetsPropertyGroup()
    {
        return $this->hasOne(WidgetsPropertyGroup::className(), ['id' => 'widgets_property_group_id']);
    }

    public function getWidgetsPropertyType()
    {
        return $this->hasOne(WidgetsPropertyType::className(), ['id' => 'widgets_property_type_id']);
    }
}
