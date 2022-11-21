<?php

use App\Common\Models\Main\Setting;

$template = Setting::template();


/**
 * @var $title string
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')

@endsection
