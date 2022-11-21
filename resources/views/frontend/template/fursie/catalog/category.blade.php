<?php

use App\Common\Models\Main\Setting;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Product\CatalogProduct;

$template = Setting::template();

/**
 * @var $title string
 * @var $model CatalogCategory
 * @var $products CatalogProduct[]
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <main>
        <div class="bg-prop home_bg"></div>
    </main>
@endsection
