<?php

namespace App\Common\Models;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Catalog\CatalogProductWidgets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

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
 * @property CatalogProductWidgets[] $catalogProductWidgets
 * @property InfoBlock[] $infoBlocks
 * @property Post[] $posts
 * @property PostCategory[] $postCategories
 */
class Render extends BaseModel
{
    protected $table = 'ax_render';

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
            'resource' => 'Resource',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogCategories()
    {
        return $this->hasMany(CatalogCategory::className(), ['render_id' => 'id']);
    }

    public function getCatalogProducts()
    {
        return $this->hasMany(CatalogProduct::className(), ['render_id' => 'id']);
    }

    public function getCatalogProductWidgets()
    {
        return $this->hasMany(CatalogProductWidgets::className(), ['render_id' => 'id']);
    }

    public function getInfoBlocks()
    {
        return $this->hasMany(InfoBlock::className(), ['render_id' => 'id']);
    }

    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['render_id' => 'id']);
    }

    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['render_id' => 'id']);
    }

    public static function classList(): array
    {
        $array = [];
        $classes = File::allFiles(app_path('Common/Models'));
        foreach ($classes as $class) {
            $classname = str_replace(
                [app_path(), '/', '.php'],
                ['App', '\\', ''],
                $class->getRealPath()
            );
            if (is_subclass_of($classname, Model::class)) {
                $model = new $classname;
                $array = [$model->getTable() => $model->getTable()];
            }
        }
        return $array;
    }

    public static function byType(Model $model): array
    {
        /* @var $item static */
        $array = [];
        $items = static::query()->where('resource', $model->getTable())->get();
        foreach ($items as $item) {
            $array[] = [
                'id' => $item->id,
                'title' => $item->title
            ];
        }
        return $array;
    }
}
