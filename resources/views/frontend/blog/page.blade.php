<?php

/**
 * @var $title string
 * @var $model Page
 */

use App\Common\Models\Page\Page;

?>
@extends('frontend.layout',['title' => $model->title ?? ''])
@section('content')
    <?= $model->description ?>
@endsection
