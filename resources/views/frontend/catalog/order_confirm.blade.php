<?php


/**
 * @var $title string
 * @var $user UserWeb
 * @var $model CatalogOrder
 */


use App\Common\Models\Catalog\Document\CatalogOrder;use App\Common\Models\User\UserWeb;


$user = UserWeb::auth();
$products = count($model->basketProducts) ? $model->basketProducts : [];
$address = $model['address_index'] . ', ' .
    $model['address_region'] . ', ' .
    $model['address_city'] . ', ' .
    $model['address_street'] . ', ' .
    $model['address_house'] . ', ' .
    $model['address_apartment'];
$address = trim($address, ', ');
$discount = $model['coupon_discount'] ?? 0;

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <div class="container order-confirm user-page">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>ИП Семенова Ирина Владимировна</h4>
                            <span><?= _unix_to_string_moscow() ?></span>
                        </div>
                        <hr>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                            <div class="col">
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>Пользователь: </strong><?= $model['user_last_name'] . ' ' . $model['user_first_name'] ?>
                                    </li>
                                    <li><strong>Доставка:</strong> <?= $model['delivery_title'] ?></li>
                                    <li><strong>Оплата:</strong> <?= $model['payment_title'] ?></li>
                                </ul>
                            </div>
                            <div class="col">
                                <ul class="list-unstyled">
                                    <li><strong>Ордер: </strong><?= $model['uuid'] ?></li>
                                    <li><strong>Дата
                                            создания:</strong> <?= _unix_to_string_moscow($model['created_at']) ?></li>
                                    <li><strong>Аккаунт:</strong> <?= $user->phone ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row row-cols-1">
                            <div class="col">
                                <address class="font-size-sm">
                                    <strong>Адрес</strong><br>
                                    <?= $address ?>
                                </address>
                            </div>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th class="text-center">№</th>
                                    <th>Продукт</th>
                                    <th>Количество</th>
                                    <th class="text-right">Цена</th>
                                    <th class="text-right">Стоимость</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $cnt = 1;
                                $sum = $sumDiscount = 0.0;
                                ?>
                                <?php if ($products) { ?>
                                <?php foreach ($products as $product){ ?>
                                <tr>
                                    <td class="text-center"><?= $cnt ?></td>
                                    <td><?= $product['product_title'] ?></td>
                                    <td class="nostretch"><?= $product['quantity'] ?></td>
                                    <td class="text-right"><?= $product['product_price'] ?> ₽</td>
                                    <td class="text-right"><?= $product['product_price'] * $product['quantity'] ?> ₽</td>
                                </tr>
                                <?php
                                $cnt++;
                                $sum += $product['product_price'] * $product['quantity'];
                                ?>
                                <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                        <tr>
                                            <th class="w-50">Итого:</th>
                                            <td class="text-right"><?= _price($sum) ?> ₽</td>
                                        </tr>
                                        <tr>
                                            <th>Скидка</th>
                                            <td class="text-right"><?= $discount ?> %</td>
                                        </tr>
                                        <tr>
                                            <th>Доставка:</th>
                                            <td class="text-right">350.00 ₽</td>
                                        </tr>
                                        <tr>
                                            <th>Итого:</th>
                                            <?php $sumDiscount = $discount ? $sum - ($sum * $discount) / 100 : $sum?>
                                            <td class="text-right"><?= _price($sumDiscount + 350) ?> ₽</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row mt-3 mb-4">
                            <button class="btn btn-light has-icon mt-1 mt-sm-0" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-printer mr-2">
                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                    <path
                                        d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                    <rect x="6" y="14" width="12" height="8"></rect>
                                </svg>
                                Печать
                            </button>
                            <button class="btn btn-success has-icon ml-sm-1 mt-1 mt-sm-0" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-credit-card mr-2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                Перейти к оплате
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-primary" role="alert">
                                    <p>Услуга оплаты через интернет осуществляется в соответствии с Правилами
                                        международных платежных систем Visa, MasterCard и Платежной системы МИР на
                                        принципах соблюдения конфиденциальности и безопасности совершения платежа, для
                                        чего используются самые современные методы проверки, шифрования и передачи
                                        данных по закрытым каналам связи. Ввод данных банковской карты осуществляется на
                                        защищенной платежной странице АО «АЛЬФА-БАНК».</p>
                                    <p>Оплачивая заказ, Вы соглашаетесь с условиями обмена, возврата и доставки
                                        товара.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection