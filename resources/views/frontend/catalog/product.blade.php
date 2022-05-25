<?php

/**
 * @var $title string
 * @var $model \App\Common\Models\Catalog\Product\CatalogProduct
 */

use App\Common\Models\Catalog\Product\CatalogProduct;

$toLayout = [
    'title' => $title ?? '',
    'script' => 'product',
    'style' => 'product',
];

$galleries = $model->manyGalleryWithImages ?? [];
$properties = $model->getProperty() ?? [];
$tabs = isset($model->widgetTabs) ? $model->widgetTabs->content : [];
$desc = '';
?>
@extends('frontend.layout',$toLayout)
@section('content')
    <main class="product-card unselectable user-page">
        <div class="container-fluid inner mb-4">
            <div class="row">
                <div class="col-sm-8 content">
                    <div class="blog-posts classic-blog">
                        <div class="post">
                            <div class="fotorama"
                                 data-allowfullscreen="true"
                                 data-autoplay="5000"
                                 data-keyboard="true"
                                 data-arrows="true"
                                 data-click="false"
                                 data-swipe="true"
                                 data-nav="thumbs"
                                 data-fit="contain"
                                 data-width="100%"
                                 data-height="100vh"
                                 data-maxheight="700px"
                                 data-transition="slide"
                                 data-thumbwidth="100"
                                 data-thumbheight="50">
                                <?php foreach ($galleries as $gallery){ ?>
                                <?php foreach ($gallery->images as $image){ ?>
                                <a href="<?= $image->getImage() ?>"><img src="<?= $image->getImage() ?>" alt=""/></a>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <aside class="col-sm-4 sidebar lp30 sidebar__right">
                    <div class="padding-top-2x mt-2 hidden-md-up"></div>
                    <h2 class="mb-3"><?= $model->title ?></h2>
                    <span class="h3 d-block">Цена: <?= $model->price ?> ₽</span>
                    <p class="text-muted"><?= $model->description ?></p>
                    <?php if ($properties){ ?>
                    <?php foreach ($properties as $property){ ?>
                    <div class="pt-1">
                        <span class="text-medium"><?= $property->property_title ?>:</span>
                        <?= $property->property_value ?>
                        <?= $property->unit_symbol ?>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <hr class="mb-4">
                    <div class="row">
                        <div class="col-sm-12 align-items-end">
                            <button
                                class="btn btn-outline-primary float-right"
                                data-js-catalog-product-id="<?= $model->id ?>">
                                Добавить в корзину
                            </button>
                            <button type="button" class="btn btn-outline-secondary float-right mr-1">Избранное</button>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="product__tabs">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php if ($tabs){ ?>
                    <?php $cnt = 0; ?>
                    <?php foreach ($tabs as $tab){ ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link <?= $cnt === 0 ? 'active' : ''?>"
                           id="description-tab-<?= $tab->id ?>"
                           data-toggle="tab"
                           href="#description-<?= $tab->id ?>"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true"><?= $tab->title_short ?? $tab->title ?></a>
                    </li>
                    <?php
                    $desc .= '<div class="tab-pane fade '.($cnt === 0 ? 'show active' : '').'"
                                    id="description-' . $tab->id . '" role="tabpanel"
                                    aria-labelledby="home-tab">
                                <h3 class="product__subtitle">' . $tab->title . '</h3>
                                <p class="product__description">' . $tab->description . '</p>
                                </div>';
                        $cnt++;
                    ?>
                    <?php } ?>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?= $desc ?>
                </div>
            </div>
        </div>
    </main>
@endsection
