<?php

namespace App\Common\Models;

use App\Common\Models\Blog\PostCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use RuntimeException;

/**
 * This is the BaseModel class.
 *
 */
class BaseModel extends Model
{
    protected static $paginate = 30;
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

    public function setErrors(array $error = self::MESSAGE_UNKNOWN): BaseModel
    {
        foreach ($error as $key => $value) {
            if (is_array($value)) {
                foreach ($error as $key2 => $value2) {
                    $this->errors[$key2][] = $value2;
                }
            }
            $this->errors[$key][] = $value;
        }
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

    public static function filter(array $post = [])
    {
        $model = static::class . 'Filter';
        if (class_exists($model)) {
            return (new $model($post))->setBuilder(static::query())->apply();
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
                    'title' => $this->id ? 'Категория №' . $this->id : 'Новая категория',
                ];
            }
            if ($mode === 'index') {
                $breadcrumb[] = [
                    'href' => '',
                    'title' => 'Список категорий',
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
}
