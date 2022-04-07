<?php

namespace App\Common\Models;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Page\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use RuntimeException;

/**
 * This is the BaseModel class.
 *
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 */
class BaseModel extends Model
{
    protected ?Builder $_builder;
    protected static array|null $_modelForSelect = null;
    protected static int $paginate = 30;
    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public const MESSAGE_UNKNOWN = ['default' => 'Произошла не предвиденная ошибка'];

    private array $errors = [];

    public static function sendErrors(array $error = self::MESSAGE_UNKNOWN): static
    {
        return (new static())->setErrors($error);
    }

    public static function rules(): array
    {
        return [];
    }

    private function appendErrors(array $error): void
    {
        foreach ($error as $key => $value) {
            if (is_array($value) && ax_is_associative($value)) {
                $this->appendErrors($value);
            }
            $this->errors[$key][] = $value;
        }
    }

    public function setErrors(array $error = self::MESSAGE_UNKNOWN): BaseModel
    {
        $this->errors = array_merge_recursive($this->errors, $error);
        return $this;
    }

    public function getImage(): string
    {
        $image = $this->image ?? null;
        return $image ? env('APP_URL', '') . $image : '';
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public static function className(string $table = 'ax_user'): ?string
    {
        $classes = File::allFiles(app_path('Common/Models'));
        foreach ($classes as $class) {
            $classname = str_replace(
                [app_path(), '/', '.php'],
                ['App', '\\', ''],
                $class->getRealPath()
            );
            if (is_subclass_of($classname, Model::class)) {
                $model = new $classname;
                if ($table === $model->getTable()) {
                    return $model::class;
                }
            }
        }
        return null;
    }

    public function safe(): static
    {
        try {
            !$this->getErrors() && $this->save();
        } catch (\Throwable $exception) {
            $error = $exception->getMessage();
            $this->setErrors(['exception' => $error]);
        }
        return $this;
    }

    public static function builder()
    {
        $model = static::class . 'Filter';
        if (class_exists($model)) {
            return (new $model([], static::query()));
        }
        throw new RuntimeException('[' . $model . '] not found in [' . __DIR__ . ']');
    }

    public static function filter(array $post = [])
    {
        $model = static::class . 'Filter';
        if (class_exists($model)) {
            return (new $model($post, static::query()))->_filter()->apply();
        }
        throw new RuntimeException('[' . $model . '] not found in [' . __DIR__ . ']');
    }

    public static function filterAll(array $post = [])
    {
        return static::filter($post)
            ->orderBy('created_at', 'desc')
            ->paginate(static::$paginate);
    }

    public function breadcrumbAdmin(string $mode = 'self'): string
    {
        $breadcrumb[] = [
            'href' => '/admin',
            'title' => 'Главная',
        ];
        if ($this instanceof PostCategory) {
            if ($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/blog/category',
                    'title' => 'Список категорий',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Категория ' . $this->title : 'Новая категория',
                ];
            }
            if ($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список категорий',
                ];
            }
        }
        if ($this instanceof Post) {
            if ($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/blog/post',
                    'title' => 'Список постов',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Пост ' . $this->title : 'Новый пост',
                ];
            }
            if ($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список постов',
                ];
            }
        }
        if ($this instanceof CatalogCategory) {
            if ($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/catalog/category',
                    'title' => 'Список категорий',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Категория ' . $this->title : 'Новая категория',
                ];
            }
            if ($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список категорий',
                ];
            }
        }
        if ($this instanceof CatalogProduct) {
            if ($mode === 'self') {
                $breadcrumb[] = [
                    'href' => '/admin/catalog/product',
                    'title' => 'Список товаров',
                ];
                $breadcrumb[] = [
                    'href' => '',
                    'title' => $this->title ? 'Товар ' . $this->title : 'Новый товар',
                ];
            }
            if ($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список товаров',
                ];
            }
        }
        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb breadcrumb-style3">';
        foreach ($breadcrumb as $item) {
            if ($item['href']) {
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
        if ($this->created_at) {
            return date('d.m.Y', $this->created_at);
        }
        return date('d.m.Y');
    }

    public function createdAtSet(string $date): void
    {
        if ($date) {
            $this->created_at = strtotime($date);
        } else {
            $this->created_at = time();
        }
    }

    public static function forSelect(): array
    {
        $subclass = static::class;
        if (!isset(self::$_modelForSelect[$subclass])) {
            self::$_modelForSelect[$subclass] = static::all()->toArray();
        }
        return self::$_modelForSelect[$subclass];
    }

    public static function table(): string
    {
        return (new static())->getTable();
    }

    public function setTitle(array $data): static
    {
        /* @var $this PostCategory|Post|CatalogCategory|CatalogProduct|Page */
        if (empty($data['title'])) {
            $this->setErrors(['title' => 'Обязательно для заполнения']);
        }
        $this->title = $data['title'];
        return $this;
    }

    public function setAlias(array $data = []): static
    {
        /* @var $this PostCategory|Post|CatalogCategory|CatalogProduct|Page */
        if (empty($data['alias'])) {
            $alias = ax_set_alias($this->title);
            $this->alias = $this->checkAlias($alias);
        } else {
            $this->alias = $this->checkAlias($data['alias']);
        }
        return $this;
    }

    protected function checkAlias(string $alias): string
    {
        /* @var $this PostCategory|Post|CatalogCategory|CatalogProduct|Page */
        $cnt = 1;
        $temp = $alias;
        while ($this->checkAliasAll($temp)) {
            $temp = $alias . '-' . $cnt;
            $cnt++;
        }
        return $temp;
    }

    public function setImagesPath(): string
    {
        /* @var $this PostCategory|Post|CatalogCategory|CatalogProduct|Page */
        return $this->getTable() . '/' . $this->alias;
    }

}
