<?php

namespace App\Common\Http\Controllers;

class BackendController extends WebController
{
    public function view($view = null, $data = [], $mergeData = [])
    {
        $path = explode('.', $view);
        $path[0] = 'backend.v1';
        $view = implode('.', $path);
        return view($view, $data, $mergeData);
    }
}
