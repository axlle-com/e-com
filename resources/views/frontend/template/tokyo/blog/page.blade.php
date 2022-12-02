<?php

use App\Common\Models\Page\Page;
use App\Common\Models\Setting\Setting;

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
