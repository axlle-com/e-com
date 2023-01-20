<?php

namespace App\Common\Models\Widgets;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Render;

/**
 * This is the model class for table "ax_widgets".
 *
 * @property int $id
 * @property int|null $render_id
 * @property string $name
 * @property string $title
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Render $render
 * @property WidgetsHasResource[] $widgetsHasResources
 * @property WidgetsHasValueDecimal[] $widgetsHasValueDecimals
 * @property WidgetsHasValueInt[] $widgetsHasValueInts
 * @property WidgetsHasValueText[] $widgetsHasValueTexts
 * @property WidgetsHasValueVarchar[] $widgetsHasValueVarchars
 */
class Widgets extends BaseModel
{
    protected $table = 'ax_widgets';

    public function getRender()
    {
        return $this->hasOne(Render::class, ['id' => 'render_id']);
    }

    public function getWidgetsHasResources()
    {
        return $this->hasMany(WidgetsHasResource::class, ['widgets_id' => 'id']);
    }

    public function getWidgetsHasValueDecimals()
    {
        return $this->hasMany(WidgetsHasValueDecimal::class, ['widgets_id' => 'id']);
    }

    public function getWidgetsHasValueInts()
    {
        return $this->hasMany(WidgetsHasValueInt::class, ['widgets_id' => 'id']);
    }

    public function getWidgetsHasValueTexts()
    {
        return $this->hasMany(WidgetsHasValueText::class, ['widgets_id' => 'id']);
    }

    public function getWidgetsHasValueVarchars()
    {
        return $this->hasMany(WidgetsHasValueVarchar::class, ['widgets_id' => 'id']);
    }
}
