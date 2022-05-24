<?php

/**
 * @var $title string
 * @var $model Page
 * @var $categories CatalogCategory[]
 * @var $category CatalogCategory
 * @var $product CatalogProduct
 */

use App\Common\Models\Catalog\CatalogCategory;use App\Common\Models\Catalog\CatalogProduct;use App\Common\Models\Page\Page;

$toLayout = [
    'title' => $title ?? '',
    'script' => 'catalog',
];
$productsArray = [];
?>
@extends('frontend.layout',$toLayout)
@section('content')
    <main class="isotope__container unselectable">
        <div class="light-wrapper">
            <div class="container-fluid">
                <div class="portfolio classic-masonry">
                    <div id="filters" class="button-group pull-right">
                        <button class="button is-checked" data-filter="*">Все</button>
                        <?php if($categories ?? null){ ?>
                        <?php foreach ($categories as $category){ ?>
                        <?php $productsArray[] = $category->productsRandom ?>
                        <button class="button" data-filter=".category-<?= $category->id ?>">
                            <?= $category->title_short ?? $category->title ?>
                        </button>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="isotope items">
                        <?php foreach ($productsArray as $products){ ?>
                        <?php foreach ($products as $product){ ?>
                        <div class="item category-<?= $product->category_id ?>">
                            <figure>
                                <a href="<?= $product->getUrl() ?>">
                                    <div class="text-overlay">
                                        <div class="info"><span><?= $product->title_short ?? $product->title ?></span>
                                        </div>
                                    </div>
                                    <img src="<?= $product->getImage() ?>" alt="">
                                </a>
                            </figure>
                        </div>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
