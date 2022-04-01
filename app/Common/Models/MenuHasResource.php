<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%menu_has_resource}}".
 *
 * @property int $menu_id
 * @property string $resource
 * @property int $resource_id
 *
 * @property Menu $menu
 */
class MenuHasResource extends BaseModel
{
    protected $table = 'ax_menu_has_resource';

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'menu_id' => 'Menu ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
        ];
    }

    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }
}
