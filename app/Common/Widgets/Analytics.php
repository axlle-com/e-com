<?php

namespace App\Common\Widgets;

use Illuminate\View\View;

class Analytics extends Widget
{
    public function run(): ?View
    {
        $debug = config('app.test');
        if (!$debug) {
            return view('widgets.analytics', ['models' => []]);
        }
        return null;
    }
}
