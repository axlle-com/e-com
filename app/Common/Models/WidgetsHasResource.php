<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%widgets_has_resource}}".
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

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'widgets_id' => 'Widgets ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
        ];
    }

    public function getWidgets()
    {
        return $this->hasOne(Widgets::class, ['id' => 'widgets_id']);
    }
}
