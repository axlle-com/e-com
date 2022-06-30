<?php

/**
 * @var $title string
 * @var $user UserWeb
 */

use App\Common\Models\User\UserWeb;

$success = session('success', '');
?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <div class="container user-page mb-5 mt-5">
        <div class="row">

        </div>
    </div>
@endsection
