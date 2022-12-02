<?php

use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Setting\Setting;
use App\Common\Models\User\UserWeb;

$template = Setting::template();

/**
 * @var $title string
 * @var $model CatalogProduct
 */

$isEmployee = false;
if (($user = UserWeb::auth()) && $user->isEmployee()) {
    $isEmployee = true;
}

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
@extends($template.'layout',$toLayout)
@section('content')
    <main class="product-card unselectable user-page">
        <div class="container-fluid inner mb-4">
            <div class="row">
                <div class="col-sm-8 content">
                    <div class="blog-posts classic-blog">
                        <div class="post">
                            <div class="fotorama">
                                <?php foreach ($galleries as $gallery){ ?>
                                    <?php foreach ($gallery->images as $image){ ?>
                                <a href="<?= $image->getImage() ?>"><img src="<?= $image->getImage() ?>" alt=""/></a>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <aside class="col-sm-4 sidebar lp30 sidebar__right product-info-block">
                    <div class="padding-top-2x mt-2 hidden-md-up"></div>
                    <h2 class="mb-3"><?= $model->title ?></h2>
                    <span class="h3 d-block">Цена: <?= _price($model->price) ?></span>
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
                        <div class="col-sm-12 align-items-end product-form js-product-form">
                            <?php if ($isEmployee){ ?>
                            <button
                                    class="btn btn-outline-primary float-right ml-1"
                                    data-js-catalog-product-id-write-off="<?= $model->id ?>">
                                Списать
                            </button>
                            <?php } ?>
                            <button
                                    class="btn btn-outline-primary float-right"
                                    data-js-catalog-product-id="<?= $model->id ?>">
                                Добавить в корзину
                            </button>
                            <?php if ($model->is_single){ ?>
                            <input type="hidden" name="quantity" value="1">
                            <?php }else{ ?>
                            <input type="number"
                                   class="form-control quantity-product float-right"
                                   name="quantity"
                                   value="1">
                            <?php } ?>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="row">
                <?php if (0){ ?>
                <div class="col-sm-8 content comment-widget">
                    <div class="comment-form-widget">
                        <form id="contact-form-leave-comments" class="row" action="/ajax/add-comment"
                              method="post">
                            <input type="hidden" name="resource" value="<?= $model->getTable() ?>">
                            <input type="hidden" name="resource_id" value="<?= $model->id ?>">
                            <input type="hidden" name="comment_id" value="">
                            <div class="col-sm-12 js-answer-name" style="display: none">
                                <div class="form-group">
                                    <div class="form-group field-name-leave-comments required">
                                        <label for="name-leave-comments">
                                            Ответить:
                                            <button class="btn btn-danger btn-sm answer-delete js-answer-delete">
                                                Удалить
                                            </button>
                                        </label>
                                        <input type="text" id="name-leave-comments"
                                               class="form-control"
                                               name="comment_name"
                                               aria-required="true" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group field-name-leave-comments required">
                                        <label for="name-leave-comments">Ваше имя</label>
                                        <input type="text" id="name-leave-comments"
                                               class="form-control"
                                               data-validator="name"
                                               data-validator-required
                                               name="name"
                                               aria-required="true">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-group field-email-leave-comments required">
                                        <label for="email-leave-comments">Ваш Email</label>
                                        <input type="text" id="email-leave-comments"
                                               class="form-control"
                                               data-validator="email"
                                               data-validator-required
                                               name="email"
                                               aria-required="true">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-group field-body-leave-comments required">
                                        <label for="body-leave-comments">Ваш отзыв</label>
                                        <textarea id="body-leave-comments"
                                                  class="form-control form-control-sm"
                                                  name="text"
                                                  data-validator="text"
                                                  data-validator-required
                                                  rows="6"
                                                  aria-required="true"></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-outline-primary btn-sm js-comment-button">
                                    Оставить отзыв
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="comment-block-widget" data-offset-top="60" id="comments">
                        <h3 class="widget-title text-lg text-uppercase">Отзывы</h3>
                            <?php if ($model->comments) { ?>
                            <?= $model->getComments() ?>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
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
                        $desc .= '<div class="tab-pane fade ' . ($cnt === 0 ? 'show active' : '') . '"
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

