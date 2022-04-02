<?php

namespace App\Common\Models;

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

    public function getWidgetsHasResources()
    {
        return $this->hasMany(WidgetsHasResource::class, ['widgets_id' => 'id']);
    }

    public static function forSelect(): array
    {
        if (empty(static::$_widgets)) {
            /* @var $model static */
            $models = static::all();
            foreach ($models as $model) {
                static::$_widgets[] = [
                    'id' => $model->id,
                    'title' => $model->title
                ];
            }
        }
        return static::$_widgets;
    }

}
