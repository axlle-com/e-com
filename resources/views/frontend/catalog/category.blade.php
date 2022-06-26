<?php

/**
 * @var $title string
 * @var $model CatalogCategory
 * @var $products CatalogProduct[]
 */

use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Product\CatalogProduct;

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <main>
        <div class="bg-prop home_bg"></div>
    </main>
@endsection
