<?php

namespace App\Common\Widgets;

use App\Common\Models\Main\Errors;
use Illuminate\View\View;

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

    public function init(): void
    {
    }

    public function run(): ?View
    {
        return null;
    }

    public static function widget($config = []): ?View
    {
        $inst = new static($config);
        $inst->init();
        return $inst->run();
    }
}
