<?php

namespace App\Common\Widgets;

use Illuminate\View\View;
use App\Common\Models\Errors\Errors;

abstract class Widget
{
    use Errors;

    private array $attributes = [];

    private function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function widget($config = []): ?View
    {
        return (new static($config))->init()->run();
    }

    public function run(): ?View
    {
        return null;
    }

    public function init(): static
    {
        return $this;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __isset($key)
    {
        return $this->attributes[$key] ?? null;
    }
}
