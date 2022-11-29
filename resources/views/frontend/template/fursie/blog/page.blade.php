<?php

use App\Common\Models\Page\Page;

/**
 * @var $title string
 * @var $template string
 * @var $model Page
 */

?>
@extends($template.'layout',['title' => $model->title ?? ''])
@section('content')
    <?= $model->description ?>
@endsection
