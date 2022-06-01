<?php

/* @var $title string
 * @var $models array
 * @var $post array
 */


$show = true;
$url = $_SERVER['REQUEST_URI'];
if (strripos($url, '/user/order') !== false) {
    $show = false;
}

$quantity = $models['quantity'] ?? 0;

?>
<div href="<?= $quantity ? '/user/order' : 'javascript:void(0)' ?>"
   class="header__cart-link user-page js-block-mini-basket">
    <svg class="header__cart-icon" viewBox="0 0 37 40">
        <path
            d="M36.5 34.8L33.3 8h-5.9C26.7 3.9 23 .8 18.5.8S10.3 3.9 9.6 8H3.7L.5 34.8c-.2 1.5.4 2.4.9 3 .5.5 1.4 1.2 3.1 1.2h28c1.3 0 2.4-.4 3.1-1.3.7-.7 1-1.8.9-2.9zm-18-30c2.2 0 4.1 1.4 4.7 3.2h-9.5c.7-1.9 2.6-3.2 4.8-3.2zM4.5 35l2.8-23h2.2v3c0 1.1.9 2 2 2s2-.9 2-2v-3h10v3c0 1.1.9 2 2 2s2-.9 2-2v-3h2.2l2.8 23h-28z">
        </path>
    </svg>
    <div
        class="header__cart-counter"
        data-cart-count-bubble=""
        style="display: <?= $quantity ? 'flex' : 'none' ?>">
        <?= $quantity ?>
    </div>
    <?php if($show && isset($models['items']) && count($models['items'])){ ?>
    <div class="toolbar-dropdown cart-dropdown js-widget-cart">
        <?php foreach ($models['items'] as $key => $model){ ?>
        <div class="entry">
            <div class="entry-thumb">
                <a href="/catalog/<?= $model['alias'] ?>">
                    <img src="<?= $model['image'] ?>" alt="<?= $model['title'] ?>">
                </a>
            </div>
            <div class="entry-content">
                <h4 class="entry-title">
                    <a href="/catalog/<?= $model['alias'] ?>"><?= $model['title'] ?></a>
                </h4>
                <div class="entry-meta"><?= $model['quantity'] ?> x <?= $model['price'] ?> ₽</div>
            </div>
            <div class="basket-change js-basket-change">
                <i class="fa fa-fw fa-caret-square-left"
                   data-js-basket-action="delete"
                   data-js-basket-id-change="<?= $key ?>"></i>
                <i class="fa fa-fw fa-caret-square-right"
                   data-js-basket-action="add"
                   data-js-basket-id-change="<?= $key ?>"></i>
            </div>
            <a href="javascript:void(0)" class="entry-delete" data-js-catalog-product-id-delete="<?= $key ?>"><i class="fa fa-fw fa-trash-restore-alt"></i></a>
        </div>
        <?php } ?>
        <div class="text-right">
            <p class="text-gray-dark py-2 mb-0"><span class="text-muted">Итого:</span> &nbsp;<?= $models['sum'] ?> ₽</p>
        </div>
        <div class="d-flex">
            <div class="pr-2 w-50">
                <a class="btn btn-outline-secondary btn-sm btn-block mb-0 js-basket-clear" href="javascript:void(0)">Очистить</a>
            </div>
            <div class="pl-2 w-50">
                <a class="btn btn-outline-primary btn-sm btn-block mb-0" href="/user/order">Оформить</a>
            </div>
        </div>
    </div>
    <?php }?>
</div>


