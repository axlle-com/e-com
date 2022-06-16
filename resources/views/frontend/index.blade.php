<?php

/**
 * @var $title string
 */

_dd_((new \App\Common\Models\Catalog\Document\DocumentComing)->set());
?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <main>
        <div class="bg-prop home_bg"></div>
    </main>
@endsection
