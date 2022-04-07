<?php

namespace App\Common\Models\Widgets;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%widgets}}".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property WidgetsContent[] $widgetsContents
 * @property WidgetsHasResource[] $widgetsHasResources
 */
class Widgets extends BaseModel
{
    protected $table = 'ax_widgets';
    private static array $_widgets = [];

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getWidgetsContents()
    {
        return $this->hasMany(WidgetsContent::class, ['widgets_id' => 'id']);
    }

    public function getWidgetsHasResources()
    {
        return $this->hasMany(WidgetsHasResource::class, ['widgets_id' => 'id']);
    }
}
