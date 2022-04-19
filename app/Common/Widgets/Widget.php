<?php

namespace App\Common\Widgets;

use App\Common\Models\Main\Setters;
use Illuminate\View\View;

class Widget
{
    use Setters;

    public function __construct($config = [])
    {
        $this->init();
    }

    public function init()
    {
    }

    public function run(): View
    {
    }

    public static function widget($config = []): View
    {
        return (new static($config))->run();
    }

    public function render(string $view, array $params): View
    {
        return view('widgets.' . $view, $params);
    }
}
