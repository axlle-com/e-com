<?php

/**
 * @var $title string
 * @var $model CatalogCategory
 * @var $products CatalogProduct[]
 */

use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <div class="container padding-bottom-3x mb-1">
        <div class="table-responsive shopping-cart">
            <table class="table">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th class="text-center">Количество</th>
                    <th class="text-center">Стоимость</th>
                    <th class="text-center">Скидка</th>
                    <th class="text-center"><a class="btn btn-sm btn-outline-danger" href="#">Очистить</a></th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($products) && $products->isNotEmpty()) { ?>
                <?php foreach ($products as $product){ ?>
                    <tr>
                    <td>
                        <div class="product-item"><a class="product-thumb" href="<?= $product->getUrl() ?>"><img src="<?= $product->getImage() ?>" alt="Product"></a>
                            <div class="product-info">
                                <h4 class="product-title"><a href="<?= $product->getUrl() ?>"><?= $product->title ?></a></h4>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="count-input">
                            1
                        </div>
                    </td>
                    <td class="text-center text-lg"><?= $product->price ?></td>
                    <td class="text-center text-lg"><?= '-' ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger">Удалить</button>
                    </td>
                </tr>
                <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="shopping-cart-footer mb-3">
            <div class="bd-example">
                <form class="form-inline">
                    <div class="form-group">
                        <label for="inputPassword2" class="sr-only">Купон</label>
                        <input type="password" class="form-control" id="inputPassword2" placeholder="Купон">
                    </div>
                    <button type="submit" class="btn btn-outline-primary mx-sm-3">Применить</button>
                </form>
            </div>
            <div class="bd-example"><span>Итого: 222</span></div>
        </div>
        <div class="shopping-cart-footer-button">
            <a type="button" href="/catalog" class="btn btn-outline-secondary">Выйти</a>
            <button type="button" class="btn btn-outline-success mx-sm-3">Оформить</button>
        </div>
    </div>
@endsection
