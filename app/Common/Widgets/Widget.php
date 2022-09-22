<?php

namespace App\Common\Widgets;

use Illuminate\View\View;
use App\Common\Models\Main\BaseComponent;

abstract class Widget extends BaseComponent
{
    public static function widget($config = []): ?View
    {
        return (new static($config))->run();
    }

    public function run(): ?View
    {
        return null;
    }
}
