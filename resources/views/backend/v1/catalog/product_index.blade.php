<?php

/** @var $title string
 * @var $models CatalogProduct[]
 * @var $post array
 */

use App\Common\Models\Catalog\Product\CatalogProduct;


$title = $title ?? 'Заголовок';

?>
@extends($layout,['title' => $title])

@section('content')
    <div class="main-body a-product-index js-index">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style3">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
        <h5><?= $title ?></h5>
        <div class="card js-product">
            <div class="card-body js-producer-inner">
                <div class="btn-group btn-group-sm mb-3" role="group">
                    <a class="btn btn-light has-icon" href="/admin/catalog/product-update">
                        <i class="material-icons mr-1">add_circle_outline</i>Новая
                    </a>
                    <a type="button" class="btn btn-light has-icon" href="/admin/catalog/product">
                        <i class="material-icons mr-1">refresh</i>Обновить
                    </a>
                    <button type="button" class="btn btn-light has-icon">
                        <i class="mr-1" data-feather="paperclip"></i>Export
                    </button>
                    <a class="btn btn-light has-icon product-sort-save js-product-sort-save">Сохранить</a>
                </div>
                @include($backendTemplate.'.catalog.inc.product_index',['models' => $models,'post' => $post])
            </div>
        </div>
    </div>
@endsection
