<?php

namespace App\Common\Models\Main;

use Illuminate\Support\Str;
use App\Common\Models\Errors\Errors;
use App\Common\Models\Errors\_Errors;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

/**
 * This is the model class basic BaseModel
 *
 *
 */
abstract class BaseComponent
{
    use Errors, HasAttributes;

    public function __construct(array $attributes = [])
    {
        if (method_exists($this, 'init')) {
            $this->init();
        }
        $this->load($attributes);
    }

    public static function model(array $attributes = []): self
    {
        return new static($attributes);
    }

    public static function rules(string $type = 'default'): array
    {
        return [][$type] ?? [];
    }

    public function load(array $attributes): self
    {
        $array = $this::rules();
        foreach ($attributes as $key => $value) {
            $setter = 'set' . Str::studly($key);
            $adepter = 'add' . Str::studly($key);
            $key = Str::snake($key);
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            } else if (method_exists($this, $adepter)) {
                $this->{$adepter}($value);
            } else {
                $this->$key = $value;
            }
            if (isset($array[$key])) {
                unset($array[$key]);
            }
        }
        if ($array) {
            foreach ($array as $key => $value) {
                if (!isset($this->{$key}) && Str::contains($value, 'required')) {
                    $format = 'Поле %s обязательно для заполнения';
                    $this->setErrors(_Errors::error([$key => sprintf($format, $key)], $this));
                }
            }
        }
        return $this;
    }

    public function validation(array $rules = []): bool
    {
        $rules = $rules ?: static::rules();
        $data = $this->getAttributes();
        if ($data) {
            if (empty($rules)) {
                return true;
            }
            $validator = Validator::make($data, $rules);
            if ($validator && $validator->fails()) {
                $this->setErrors(_Errors::error($validator->messages()->toArray(), $this));
            } else if ($validator == false) {
                $this->setErrors(_Errors::error('Непредвиденная ошибка', $this));
            } else {
                return true;
            }
        }
        return false;
    }
}
