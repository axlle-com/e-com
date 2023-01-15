<?php

use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Page\Page;
use App\Common\Models\Setting\Setting;

/**
 * @var $title string
 * @var $categories CatalogCategory[]
 * @var $category CatalogCategory
 * @var $product CatalogProduct
 */

$template = Setting::template();

$toLayout = [
    'title' => $title ?? '',
    'script' => 'catalog',
    'style' => 'catalog',
];
$productsArray = [];
?>
@extends($template.'layout',$toLayout)
@section('content')
    <main class="isotope__container unselectable">
        <div class="light-wrapper">
            <div class="container-fluid">
                <div class="portfolio classic-masonry">
                    <div id="filters" class="button-group pull-right">
                        <button class="button is-checked" data-filter="*">Все</button>
                        <?php if ($categories ?? null){ ?>
                            <?php foreach ($categories as $category){ ?>
                            <?php if (count($productsRandom = $category->productsRandom)){ ?>
                            <?php foreach ($productsRandom as $product) { ?>
                            <?php $products[] = $product ?>
                        <?php } ?>
                        <button class="button" data-filter=".category-<?= $category->id ?>">
                                <?= $category->title_short ?? $category->title ?>
                        </button>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="isotope items">
                        <?php $products = $products ?? []; ?>
                        <?php shuffle($products); ?>
                        <?php foreach ($products ?? [] as $product){ ?>
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
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
