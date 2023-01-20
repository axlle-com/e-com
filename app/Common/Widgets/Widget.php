<?php

namespace App\Common\Widgets;

use App\Common\Models\Main\BaseComponent;
use Illuminate\View\View;

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
