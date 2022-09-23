<?php

namespace App\Common\Models\Widgets;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "ax_widgets_has_resource".
 *
 * @property int $widgets_id
 * @property string $resource
 * @property int $resource_id
 *
 * @property Widgets $widgets
 */
class WidgetsHasResource extends BaseModel
{
    protected $table = 'ax_widgets_has_resource';

    public function getWidgets()
    {
        return $this->hasOne(Widgets::class, ['id' => 'widgets_id']);
    }
}
