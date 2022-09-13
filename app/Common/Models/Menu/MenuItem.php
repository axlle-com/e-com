<?php

namespace App\Common\Models\Menu;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%menu_item}}".
 *
 * @property int $id
 * @property int $menu_id
 * @property int|null $menu_item_id
 * @property string|null $resource
 * @property int|null $resource_id
 * @property string $title
 * @property int|null $sort
 * @property string $url
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Menu $menu
 * @property MenuItem $menuItem
 * @property MenuItem[] $menuItems
 */
class MenuItem extends BaseModel
{
    protected $table = 'ax_menu_item';

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
            'menu_id' => 'Menu ID',
            'menu_item_id' => 'Menu Item ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
            'title' => 'Title',
            'sort' => 'Sort',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }

    public function getMenuItem()
    {
        return $this->hasOne(__CLASS__, ['id' => 'menu_item_id']);
    }

    public function getMenuItems()
    {
        return $this->hasMany(__CLASS__, ['menu_item_id' => 'id']);
    }
}
