<?php

namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * This is the BaseModel class".
 *
 */
class BaseModel extends Model
{
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
        return $image ? env('APP_URL', '') . $image : '/img/photo.svg';
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
}
