<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property MenuHasResource[] $menuHasResources
 * @property MenuItem[] $menuItems
 */
class Menu extends BaseModel
{
    protected $table = 'ax_menu';
    private static array $_menu = [];

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
            'title' => 'Title',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public function getMenuHasResources()
    {
        return $this->hasMany(MenuHasResource::class, ['menu_id' => 'id']);
    }
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::class, ['menu_id' => 'id']);
    }

    public static function forSelect(): array
    {
        if (empty(static::$_menu)) {
            /* @var $model static */
            $models = static::all();
            foreach ($models as $model) {
                static::$_menu[] = [
                    'id' => $model->id,
                    'title' => $model->title
                ];
            }
        }
        return static::$_menu;
    }
}
