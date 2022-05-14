<?php

namespace App\Common\Widgets;

use Illuminate\View\View;

class AnalyticsWidget extends Widget
{
    public function run(): ?View
    {
        $debug = env('APP_IS_TEST', false);
        if (!$debug) {
            return view('widgets.analytics', ['models' => []]);
        }
        return null;
    }
}
