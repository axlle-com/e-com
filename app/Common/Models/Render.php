<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;

/**
 * This is the model class for table "{{%render}}".
 *
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string|null $resource
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogCategory[] $catalogCategories
 * @property CatalogProduct[] $catalogProducts
 * @property InfoBlock[] $infoBlocks
 * @property Post[] $posts
 * @property PostCategory[] $postCategories
 */
class Render extends BaseModel
{
    protected $table = 'ax_render';

    public static function rules(string $type = 'default'): array
    {
        return [
                'default' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Name',
            'resource' => 'Resource',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogCategories()
    {
        return $this->hasMany(CatalogCategory::class, ['render_id' => 'id']);
    }

    public function getCatalogProducts()
    {
        return $this->hasMany(CatalogProduct::class, ['render_id' => 'id']);
    }

    public function getInfoBlocks()
    {
        return $this->hasMany(InfoBlock::class, ['render_id' => 'id']);
    }

    public function getPosts()
    {
        return $this->hasMany(Post::class, ['render_id' => 'id']);
    }

    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::class, ['render_id' => 'id']);
    }
}
