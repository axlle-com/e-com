<?php

namespace Web\Backend\Controllers;

use App\Common\Http\Controllers\BackendController;
use App\Common\Http\Controllers\WebController;

class DashboardController extends BackendController
{
    public function index()
    {
        $title = 'Аналитика';
        return $this->view('backend.dashboard', ['title' => $title]);
    }

    public function test()
    {
        return $this->view('backend.dashboard');
    }
}
