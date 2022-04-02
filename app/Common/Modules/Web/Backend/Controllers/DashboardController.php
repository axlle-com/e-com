<?php

namespace App\Common\Modules\Web\Backend\Controllers;

use App\Common\Http\Controllers\WebController;

class DashboardController extends WebController
{
    public function index()
    {
        $title = 'Аналитика';
        return view('backend.dashboard', ['title' => $title]);
    }

    public function test()
    {
        return view('backend.dashboard');
    }
}
