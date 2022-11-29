<?php

use App\Common\Models\Main\Setting;
use App\Common\Models\Page\Page;

$template = Setting::template();

/**
 * @var $title string
 * @var $model Page
 */

?>
@extends($template.'layout',['title' => $model->title ?? ''])
@section('content')
    <?= $model->description ?>
@endsection
