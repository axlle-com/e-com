<?php

namespace Web\Frontend\Controllers;

use App\Common\Http\Controllers\WebController;

class SiteController extends WebController
{
    public function index()
    {
        return view('frontend.index');
    }

    public function route($alias)
    {
        dd($alias);
        return view('frontend.index');
    }
}
