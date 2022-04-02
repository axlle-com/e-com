<?php

namespace App\Common\Models;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;
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
 * @property InfoBlock[] $infoBlocks
 * @property Post[] $posts
 * @property PostCategory[] $postCategories
 */
class Render extends BaseModel
{
    protected $table = 'ax_render';
    private static array $_renders = [];

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

    public static function forSelect(): array
    {
        if (empty(static::$_renders)) {
            /* @var $model static */
            $models = static::all();
            foreach ($models as $model) {
                static::$_renders[] = [
                    'id' => $model->id,
                    'title' => $model->title
                ];
            }
        }
        return static::$_renders;
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
