<?php

use App\Common\Models\Main\Setting;
use App\Common\Models\Catalog\Category\CatalogCategory;

$template = Setting::template();

/**
 * @var $title string
 * @var $model CatalogCategory
 * @var $models array
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <div class="container padding-bottom-3x mb-1 js-basket-max-block user-page">
        <div class="table-responsive shopping-cart">
            <table class="table">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th class="text-center">Количество</th>
                    <th class="text-center">Стоимость</th>
                    <th class="text-center">Скидка</th>
                    <th class="text-center">
                        <a class="btn btn-sm btn-outline-danger js-basket-clear" href="javascript:void(0)">Очистить</a>
                    </th>
                </tr>
                </thead>
                <tbody class="">
                <?php if (isset($models)) { ?>
                <?php foreach ($models['items'] as $key => $model){ ?>
                <tr>
                    <td>
                        <div class="product-item">
                            <a class="product-thumb" href="/catalog/<?= $model['alias'] ?>">
                                <img src="<?= $model['image'] ?>" alt="Product">
                            </a>
                            <div class="product-info">
                                <h4 class="product-title">
                                    <a href="/catalog/<?= $model['alias'] ?>"><?= $model['title'] ?></a>
                                </h4>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="count-input">
                            1
                        </div>
                    </td>
                    <td class="text-center text-lg"><?= $model['price'] ?> ₽</td>
                    <td class="text-center text-lg"><?= '-' ?></td>
                    <td class="text-center">
                        <button type="button"
                                class="btn btn-sm btn-outline-danger"
                                data-js-basket-max="true"
                                data-js-catalog-product-id-delete="<?= $key ?>">
                            Удалить
                        </button>
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
                        <div class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary mx-sm-3">Применить</button>
                </form>
            </div>
            <div class="bd-example">
                <span>Итого: <span class="js-basket-max-sum"><?= $models['sum'] ?? '' ?> ₽</span></span>
            </div>
        </div>
        <div class="shopping-cart-footer-button">
            <a type="button" href="/catalog" class="btn btn-outline-secondary">Выйти</a>
            <button type="button" class="btn btn-outline-primary mx-sm-3">Оформить</button>
        </div>
    </div>
@endsection
