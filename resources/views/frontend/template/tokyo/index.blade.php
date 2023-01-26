<?php

use App\Common\Assets\MainAsset;
use App\Common\Models\Setting\Setting;

$template = Setting::template();

/**
 * @var $title string
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    @include($template.'.render.index', ['title' => $title ?? ''])
@endsection
