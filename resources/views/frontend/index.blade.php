<?php

/**
 * @var $title string
 */

\App\Common\Assets\Resource::model();
?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <main>
        <div class="bg-prop home_bg"></div>
    </main>
@endsection
