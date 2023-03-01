<?php

namespace App\Common\Models\Main;

/**
 *
 *
 */
abstract class BaseService
{
    private array $_attributes = [];

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
        if(!$key) {
            return null;
        }
        if(method_exists(static::class, $key)) {
            return $this->$key;
        }
        return $this->_attributes[$key] ?? null;
    }

    public function setAttribute($key, $value): static
    {
        if(method_exists(static::class, $key)) {
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
