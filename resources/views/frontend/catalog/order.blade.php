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
                                Доставка и oплата
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a class="nav-link" href="#order-tab-4" role="tab" data-toggle="tab" aria-controls="profile" aria-selected="false">
                                Подтверждение
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
                                </div>
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_region_input">Регион</label>
                                        <input
                                            type="text"
                                            name="user_region"
                                            class="form-control"
                                            id="order_region_input"
                                            data-synchronization="delivery_region"
                                            data-validator-required
                                            data-validator="region">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_city_input">Населенный пункт/Город</label>
                                        <input
                                            type="text"
                                            name="user_city"
                                            value=""
                                            class="form-control"
                                            id="order_city_input"
                                            data-synchronization="delivery_city.city"
                                            data-validator-required
                                            data-validator="city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_street_input">Улица</label>
                                        <input
                                            type="text"
                                            name="user_street"
                                            class="form-control"
                                            id="order_street_input"
                                            data-synchronization="delivery_street"
                                            data-validator-required
                                            data-validator="region">
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
                                            data-validator-required
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
                                        <label for="order_street_input">Улица</label>
                                        <input
                                            type="text"
                                            name="delivery_street"
                                            class="form-control"
                                            id="order_street_input"
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
                        <div role="tabpanel" class="tab-pane fade" id="order-tab-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4>ИП Семенова Ирина Владимировна</h4>
                                                <span><?= _unix_to_string_moscow() ?></span>
                                            </div>
                                            <hr>
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                                                <div class="col">
                                                    <address class="font-size-sm">
                                                        <strong>John Doe</strong><br>
                                                        795 Folsom Ave, Suite 600<br>
                                                        San Francisco, CA 94107<br>
                                                        Phone: (555) 539-1037<br>
                                                        Email: dipivweb@nudjad.ke
                                                    </address>
                                                </div>
                                                <div class="col">
                                                    <ul class="list-unstyled">
                                                        <li><strong>Ордер: </strong><?= _uniq_id() ?></li>
                                                        <li><strong>Дата создания:</strong> <?= _unix_to_string_moscow() ?></li>
                                                        <li><strong>Пользователь:</strong> <?= $user->email ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="table-responsive my-3">
                                                <table class="table table-striped table-sm">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">№</th>
                                                        <th>Продукт</th>
                                                        <th>Количество</th>
                                                        <th class="text-right">Стоимость</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if (isset($models)) { ?>
                                                    <?php foreach ($models['items'] as $key => $model){ ?>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td><?= $model['title'] ?></td>
                                                        <td class="nostretch"><?= $model['quantity'] ?></td>
                                                        <td class="text-right"><?= $model['price'] ?> ₽</td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row row-cols-2">
                                                <div class="col">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <tbody>
                                                            <tr>
                                                                <th class="w-50">Итого:</th>
                                                                <td>$250.30</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Скидка</th>
                                                                <td>$10.34</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Доставка:</th>
                                                                <td>$5.80</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Итого:</th>
                                                                <td>$265.24</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column flex-sm-row mt-3">
                                                <button class="btn btn-light has-icon mt-1 mt-sm-0" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer mr-2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>Print
                                                </button>
                                                <button class="btn btn-primary has-icon ml-sm-auto mt-1 mt-sm-0" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download mr-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>Generate PDF
                                                </button>
                                                <button class="btn btn-success has-icon ml-sm-1 mt-1 mt-sm-0" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card mr-2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>Submit Payment
                                                </button>
                                            </div>
                                        </div>
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
