<?php

/**
 * @var $title string
 * @var $model Page
 */

use App\Common\Models\Page\Page;

?>
@extends('frontend.layout',['title' => $model->title ?? ''])
@section('content')
    <main>
        <div class="bg-prop contact_bg"></div>
    </main>
@endsection
