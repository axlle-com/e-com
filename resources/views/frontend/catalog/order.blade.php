<?php

/**
 * @var $title string
 * @var $user UserWeb
 */

use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogPaymentType;
use App\Common\Models\User\UserWeb;

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <div class="container order-page user-page">
        <div class="row">
            <div class="col-md-12">
                <form class="big">
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
                                Адрес
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a class="nav-link" href="#order-tab-4" role="tab" data-toggle="tab" aria-controls="profile" aria-selected="false">
                                Оплата
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
                                                    data-js-catalog-product-id="<?= $key ?>">
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
                                    <input type="password" class="form-control" id="inputPassword2" placeholder="Купон">
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
                                            data-validator-required
                                            data-validator="last_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_phone_input">Номер телефона</label>
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control phone-mask"
                                            id="order_phone_input"
                                            data-validator="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_email_input">Почта</label>
                                        <input
                                            type="email"
                                            name="email"
                                            value=""
                                            class="form-control"
                                            id="order_email_input"
                                            data-validator="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_region_input">Регион</label>
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control"
                                            id="order_region_input"
                                            data-validator="region">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_city_input">Населенный пункт/Город</label>
                                        <input
                                            type="email"
                                            name="email"
                                            value=""
                                            class="form-control"
                                            id="order_city_input"
                                            data-validator="city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_street_input">Улица</label>
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control phone-mask"
                                            id="order_street_input"
                                            data-validator="region">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_house_Input">Дом</label>
                                        <input
                                            type="email"
                                            name="email"
                                            value=""
                                            class="form-control"
                                            id="order_house_Input"
                                            data-validator="city">
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
                                            data-placeholder="Способ доставки"
                                            data-select2-search="true"
                                            name="type">
                                            <option></option>
                                            <?php foreach (CatalogDeliveryType::forSelect() as $item){ ?>
                                            <option value="<?= $item['id'] ?>"><?=  $item['title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_region_input">Регион</label>
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control"
                                            id="order_region_input"
                                            data-validator="region">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_city_input">Населенный пункт/Город</label>
                                        <input
                                            type="email"
                                            name="email"
                                            value=""
                                            class="form-control"
                                            id="order_city_input"
                                            data-validator="city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_street_input">Улица</label>
                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control"
                                            id="order_street_input"
                                            data-validator="region">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_house_Input">Дом</label>
                                        <input
                                            type="email"
                                            name="email"
                                            value=""
                                            class="form-control"
                                            id="order_house_Input"
                                            data-validator="city">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="order-tab-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select
                                            class="form-control select2"
                                            data-allow-clear="true"
                                            data-placeholder="Способ оплаты"
                                            data-select2-search="true"
                                            name="type">
                                            <option></option>
                                            <?php foreach (CatalogPaymentType::forSelect() as $item){ ?>
                                            <option value="<?= $item['id'] ?>"><?=  $item['title'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between paddin-top-1x mt-4">
                        <a class="btn btn-outline-secondary" href="#">
                            <i class="icon-arrow-left"></i>
                            <span class="hidden-xs-down">&nbsp;Назад</span>
                        </a>
                        <a class="btn btn-outline-primary" href="#">
                            <span class="hidden-xs-down">Вперед&nbsp;</span>
                            <i class="icon-arrow-right"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
