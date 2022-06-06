<?php

/**
 * @var $title string
 * @var $user UserWeb
 */

use App\Common\Models\Catalog\CatalogDeliveryType;use App\Common\Models\Catalog\CatalogPaymentType;use App\Common\Models\User\UserWeb;

$user = UserWeb::auth() ?? new UserWeb();

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <div class="container order-page user-page">
        <div class="row">
            <div class="col-md-12">
                <form class="big" action="/catalog/ajax/order-save">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a class="nav-link active" href="#order-tab-1" role="tab" data-toggle="tab" aria-controls="home" aria-selected="true">
                                Корзина
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a class="nav-link" href="#order-tab-2" role="tab" data-toggle="tab" aria-controls="profile" aria-selected="false">
                                Контактные данные
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a class="nav-link" href="#order-tab-3" role="tab" data-toggle="tab" aria-controls="profile" aria-selected="false">
                                Доставка и oплата
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane js-basket-max-block fade show active" id="order-tab-1">
                            <div class="table-responsive shopping-cart">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Товар</th>
                                        <th class="text-center">Количество</th>
                                        <th class="text-center">Остаток</th>
                                        <th class="text-center">Стоимость</th>
                                        <th class="text-center">Скидка</th>
                                        <th class="text-center">
                                            <a class="btn btn-sm btn-outline-danger js-basket-clear"
                                               href="javascript:void(0)">Очистить</a>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="">
                                    <?php if (isset($models)) { ?>
                                    <?php foreach ($models['items'] as $key => $model){ ?>
                                    <tr
                                            class="js-basket-form"
                                            data-js-basket-max="true"
                                            data-js-catalog-product="<?= $key ?>">
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
                                                <input type="number" class="form-control quantity-product"
                                                       name="quantity" value="<?= $model['quantity'] ?>">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="count-input">
                                                <?= $model['real_quantity'] ?> шт.
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
                                    <label for="inputPassword2" class="sr-only">Купон</label>
                                    <input type="text" name="coupon" class="form-control" id="inputPassword2" placeholder="Купон">
                                    <div class="invalid-feedback"></div>
                                    <button type="submit" class="btn btn-outline-primary mx-sm-3">Применить</button>
                                </div>
                                <div class="bd-example">
                                    <span>Итого: <span class="js-basket-max-sum"><?= $models['sum'] ?? '' ?> ₽</span></span>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="order-tab-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_first_name">Имя</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="order_first_name"
                                            name="first_name"
                                            value="<?= $user->first_name ?? '' ?>"
                                            data-validator-required
                                            data-validator="first_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_last_name">Фамилия</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="order_last_name"
                                            name="last_name"
                                            value="<?= $user->last_name ?? '' ?>"
                                            data-validator-required
                                            data-validator="last_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_region_input">Регион</label>
                                        <input
                                            type="text"
                                            name="user_region"
                                            class="form-control"
                                            id="order_region_input"
                                            data-synchronization="delivery_region"
                                            data-validator="user_region">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_city_input">Населенный пункт/Город</label>
                                        <input
                                            type="text"
                                            name="user_city"
                                            value=""
                                            class="form-control"
                                            id="order_city_input"
                                            data-synchronization="delivery_city.city"
                                            data-validator="user_city">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_street_input">Улица</label>
                                        <input
                                            type="text"
                                            name="user_street"
                                            class="form-control"
                                            id="order_street_input"
                                            data-synchronization="delivery_street"
                                            data-validator="user_street">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_house_Input_delivery">Дом</label>
                                        <input
                                            type="text"
                                            name="user_house"
                                            value=""
                                            class="form-control"
                                            id="order_house_Input_delivery"
                                            data-synchronization="delivery_house"
                                            data-validator="user_house">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="order_phone_input">Номер телефона</label>
                                                <input
                                                    type="text"
                                                    name="phone"
                                                    value="<?= $user->getPhone() ?? '' ?>"
                                                    class="form-control phone-mask"
                                                    id="order_phone_input"
                                                    data-validator-required
                                                    data-validator="phone">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="order_phone_input">Обязательно</label>
                                                <a class="btn btn-outline-primary d-block js-user-phone-activate-button">
                                                    Подтвердить
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="order_email_input">Почта</label>
                                                <input
                                                    type="email"
                                                    name="email"
                                                    value="<?= $user->email ?? '' ?>"
                                                    class="form-control"
                                                    id="order_email_input"
                                                    data-validator-required
                                                    data-validator="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="order-tab-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select
                                            class="form-control select2"
                                            data-allow-clear="true"
                                            data-placeholder="Способ оплаты"
                                            data-select2-search="true"
                                            data-validator-required
                                            data-validator="payment_type"
                                            name="payment_type">
                                            <option></option>
                                            <?php foreach (CatalogPaymentType::forSelect() as $item){ ?>
                                            <option value="<?= $item['id'] ?>"><?=  $item['title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select
                                            class="form-control select2"
                                            data-allow-clear="true"
                                            data-placeholder="Способ доставки"
                                            data-select2-search="true"
                                            data-validator-required
                                            data-validator="delivery_type"
                                            name="type">
                                            <option></option>
                                            <?php foreach (CatalogDeliveryType::forSelect() as $item){ ?>
                                            <option value="<?= $item['id'] ?>"><?=  $item['title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="alert alert-primary" role="alert">
                                        <p>Курьер по г.Краснодар - 350р. Срок доставки 2-3 дня с момента оформления
                                            заказа.</p>
                                        <p>СДЭК/Почтой России по всем городам России - 350 руб.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_region_input_delivery">Регион</label>
                                        <input
                                            type="text"
                                            name="delivery_region"
                                            class="form-control"
                                            id="order_region_input_delivery"
                                            data-validator-required
                                            data-validator="delivery_region">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_city_input_delivery">Населенный пункт/Город</label>
                                        <input
                                            type="text"
                                            name="delivery_city"
                                            value=""
                                            class="form-control"
                                            id="order_city_input_delivery"
                                            data-validator-required
                                            data-validator="delivery_city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_delivery_street_input">Улица</label>
                                        <input
                                            type="text"
                                            name="delivery_street"
                                            class="form-control"
                                            id="order_delivery_street_input"
                                            data-validator-required
                                            data-validator="delivery_street">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_house_Input">Дом</label>
                                        <input
                                            type="text"
                                            name="delivery_house"
                                            value=""
                                            class="form-control"
                                            id="order_house_Input"
                                            data-validator-required
                                            data-validator="delivery_house">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between paddin-top-1x mt-4">
                        <a class="btn btn-outline-secondary" data-js-tab-order="prev" href="#">
                            <i class="icon-arrow-left"></i>
                            <span class="hidden-xs-down">Назад</span>
                        </a>
                        <a class="btn btn-outline-primary" data-js-tab-order="next" href="#">
                            <span class="hidden-xs-down">Вперед</span>
                            <i class="icon-arrow-right"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
