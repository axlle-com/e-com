<?php

namespace App\Common\Models\Main;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Errors\Errors;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Page\Page;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * This is the BaseModel class.
 *
 * @property int $id
 * @property string|null $title
 *
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 */
abstract class BaseModel extends Model implements Status
{
    use Errors;

    protected static ?array $_modelForSelect = null;
    protected static int $paginate = 30;
    protected string $formatString = 'Поле %s обязательно для заполнения';
    protected ?Builder $_builder;
    protected Collection $collection;
    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'date_pub' => 'timestamp',
        'date_end' => 'timestamp',
    ];
    protected bool $isNew = false;

    protected static function boot()
    {
        self::creating(static function($model) { });
        self::created(static function($model) { });
        self::updating(static function($model) { });
        self::updated(static function($model) { });
        self::deleting(static function($model) { });
        self::deleted(static function($model) { });
        parent::boot();
    }

    public static function className(string $table = 'ax_user'): ?string
    {
        $classes = File::allFiles(app_path('Common/Models'));
        foreach($classes as $class) {
            $classname = str_replace([
                app_path(),
                '/',
                '.php',
            ], [
                'App',
                '\\',
                '',
            ], $class->getRealPath());
            if(is_subclass_of($classname, Model::class)) {
                $model = new $classname;
                if($table === $model->getTable()) {
                    return $model::class;
                }
            }
        }

        return null;
    }

    public function getTable(string $column = ''): string
    {
        return $this->table . $column ?? 'ax_' . Str::snake(Str::pluralStudly(class_basename($this))) . $column;
    }

    public static function filterAll(array $post = [])
    {
        return static::filter($post)->orderBy('created_at', 'desc')->paginate(static::$paginate);
    }

    public static function filter(array $post = []): Builder
    {
        $model = static::class . 'Filter';
        if(class_exists($model)) {
            /** @var QueryFilter $filter */
            $filter = new $model($post, static::class);

            return $filter->_filter()->apply() ?? throw new RuntimeException('Oops something went wrong');
        }
        throw new NotFoundResourceException('[' . $model . '] not found in [' . __DIR__ . ']');
    }

    public static function forSelect(): array
    {
        $subclass = static::class;
        if( !isset(self::$_modelForSelect[$subclass])) {
            self::$_modelForSelect[$subclass] = static::all()->toArray();
        }

        return self::$_modelForSelect[$subclass];
    }

    public static function createOrUpdate(array $post): static
    {
        /** @var static $model */
        if(empty($post['id']) || !$model = static::query()->where(static::table() . '.id', $post['id'])->first()) {
            return static::create($post);
        }

        return $model->loadModel($post)->safe();
    }

    public static function create(array $post): static
    {
        $model = new static();
        $model->isNew = true;
        return $model->loadModel($post)->safe();
    }

    public function loadModel(array $data = []): static
    {
        if( !empty($this->fillable)) {
            $dataNew = [];
            foreach($this->fillable as $key) {
                $dataNew[$key] = $data[$key] ?? $this->attributes[$key] ?? null;
            }
            $data = $dataNew;
        }

        $array = $this::rules('create_db');
        foreach($data as $key => $value) {
            $setter = 'set' . Str::studly($key);
            if(method_exists($this, $setter)) {
                $this->{$setter}($value);
            } else {
                if(in_array($key, $this->fillable, true)) {
                    $this->{$key} = $value;
                }
            }
            unset($array[$key]);
        }
        if($array) {
            foreach($array as $key => $value) {
                if( !$this->{$key} && Str::contains($value, 'required')) {
                    $format = 'Поле %s обязательно для заполнения';
                    $this->setErrors(_Errors::error([$key => sprintf($format, $key)], $this));
                }
            }
        }

        return $this;
    }

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    protected function setDefaultValue(): static { return $this; }

    public function breadcrumbAdmin(string $mode = 'self'): string
    {
        $breadcrumb[] = [
            'href' => '/admin',
            'title' => 'Главная',
        ];
        if($this instanceof CatalogProperty) {
            if($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/catalog/property',
                    'title' => 'Список свойств',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Свойство ' . $this->title : 'Новое свойство',
                ];
            }
            if($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список свойств',
                ];
            }
        }
        if($this instanceof PostCategory) {
            if($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/blog/category',
                    'title' => 'Список категорий',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Категория ' . $this->title : 'Новая категория',
                ];
            }
            if($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список категорий',
                ];
            }
        }
        if($this instanceof Post) {
            if($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/blog/post',
                    'title' => 'Список постов',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Пост ' . $this->title : 'Новый пост',
                ];
            }
            if($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список постов',
                ];
            }
        }
        if($this instanceof CatalogCategory) {
            if($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/catalog/category',
                    'title' => 'Список категорий',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Категория ' . $this->title : 'Новая категория',
                ];
            }
            if($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список категорий',
                ];
            }
        }
        if($this instanceof CatalogProduct) {
            if($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/catalog/product',
                    'title' => 'Список товаров',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Товар ' . $this->title : 'Новый товар',
                ];
            }
            if($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список товаров',
                ];
            }
        }
        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb breadcrumb-style3">';
        foreach($breadcrumb as $item) {
            if($item['href']) {
                $html .= '<li class="breadcrumb-item"><a href="' . $item['href'] . '">' . $item['title'] . '</a></li>';
            } else {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . $item['title'] . '</li>';
            }
        }
        $html .= '</ol></nav>';

        return $html;
    }

    public function createdAt(): string
    {
        if($this->created_at) {
            return date('d.m.Y', $this->created_at);
        }

        return date('d.m.Y');
    }

    public function createdAtSet(string $date = null): void
    {
        if($date) {
            $this->created_at = strtotime($date);
        } else {
            $this->created_at = time();
        }
    }

    public function deleteImage(): static
    {
        /** @var $this PostCategory|Post|CatalogCategory|CatalogProduct|Page|Gallery|GalleryImage */
        if( !$this->deleteImageFile()->getErrors()) {
            return $this->safe();
        }

        return $this;
    }

    public function deleteImageFile(): static
    {
        /** @var $this PostCategory|Post|CatalogCategory|CatalogProduct|Page|Gallery|GalleryImage */
        if($this->image) {
            try {
                unlink(public_path($this->image));
                $this->image = null;
            } catch(Exception $exception) {
                $this->setErrors(_Errors::exception($exception, $this));
            }
        }

        return $this;
    }

    public function safe(): static
    {
        try {
            $attributes = [];
            if( !empty($fields = func_get_args())) {
                foreach($fields as $field) {
                    $attributes[$field] = $this->{$field};
                    unset($this->{$field});
                }
            }
            !$this->getErrors() && $this->save();
            if( !empty($attributes)) {
                foreach($attributes as $attribute => $value) {
                    $this->{$attribute} = $value;
                }
            }
        } catch(Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }

        return $this;
    }

    public function getCollection(): ?Collection
    {
        if( !isset($this->collection)) {
            $this->collection = $this->newCollection();
        }

        return $this->collection;
    }

    public function setCollection(array $collection = []): static
    {
        $this->collection = $this->newCollection($collection);

        return $this;
    }

    public function getImage(): string
    {
        $image = $this->image ?? null;
        if(( !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443) {
            $ip = 'https://' . $_SERVER['SERVER_NAME'];
        } else {
            $ip = 'http://' . $_SERVER['SERVER_NAME'];
        }

        return $image ? $ip . $image : '';
    }

    public function updateModel(array $data): static
    {
        return $this->loadModel($data)->safe();
    }

    public function setImagesPath(): string
    {
        return $this->getTable() . '/' . ($this->alias ?? $this->id);
    }

    public static function table(string $column = ''): string
    {
        $column = $column ? '.' . trim($column, '.') : '';

        return (new static())->getTable($column);
    }

    public function setTitle(string $title): static
    {
        /** @var static $this */
        if(empty($title)) {
            $this->setErrors(_Errors::error(['title' => sprintf($this->formatString, 'title')], $this));
        }
        $this->title = $title;

        return $this;
    }

}
