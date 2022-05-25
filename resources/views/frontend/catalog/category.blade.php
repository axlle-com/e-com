<?php

/**
 * @var $title string
 * @var $model CatalogCategory
 * @var $products \App\Common\Models\Catalog\Product\CatalogProduct[]
 */

use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\Product\CatalogProduct;

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <main>
        <div class="bg-prop home_bg"></div>
    </main>
@endsection
