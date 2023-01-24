<?php

namespace App\Common\Models\Main;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Errors\Errors;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * This is the model class basic BaseModel
 *
 *
 */
abstract class BaseComponent
{
    use Errors;
    use Singleton;

    private array $_attributes = [];

    public function init(): static
    {
        return $this;
    }

    public function load(array $_attributes): static
    {
        $array = $this::rules();
        foreach ($_attributes as $key => $value) {
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

    public static function rules(string $type = 'default'): array
    {
        return [][$type] ?? [];
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
            } else if ($validator === false) {
                $this->setErrors(_Errors::error('Непредвиденная ошибка', $this));
            } else {
                return true;
            }
        }
        return false;
    }

    public function getAttributes(): array
    {
        return $this->_attributes;
    }

    public function toArray(): array
    {
        return array_merge($this->_attributes, get_object_vars($this));
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        if (!$key) {
            return null;
        }
        if (method_exists(static::class, $key)) {
            return $this->$key;
        }
        return $this->_attributes[$key] ?? null;
    }

    public function setAttribute($key, $value): static
    {
        if (method_exists(static::class, $key)) {
            $this->$key = $value;
        } else {
            $this->_attributes[$key] = $value;
        }
        return $this;
    }

    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    public function offsetExists($offset): bool
    {
        return !is_null($this->getAttribute($offset));
    }

    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    public function offsetUnset($offset): void
    {
        unset($this->_attributes[$offset]);
    }
}
