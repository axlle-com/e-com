<?php

namespace App\Common\Models\Widgets;

use App\Common\Models\Main\BaseModel;

/**
* This is the model class for table "ax_widgets_has_value_decimal".
*
* @property int $id
* @property int $widgets_id
* @property int $widgets_property_id
* @property float $value
* @property int|null $created_at
* @property int|null $updated_at
* @property int|null $deleted_at
*
* @property WidgetsProperty $widgetsProperty
* @property Widgets $widgets
*/
class WidgetsHasValueDecimal extends BaseModel
{
    protected $table = 'ax_widgets_has_value_decimal';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];;
    }

    public function attributeLabels()
    {
    return [
            'id' => 'ID',
            'widgets_id' => 'Widgets ID',
            'widgets_property_id' => 'Widgets Property ID',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getWidgetsProperty()
    {
    return $this->hasOne(WidgetsProperty::class, ['id' => 'widgets_property_id']);
    }

    public function getWidgets()
    {
    return $this->hasOne(Widgets::class, ['id' => 'widgets_id']);
    }
}
