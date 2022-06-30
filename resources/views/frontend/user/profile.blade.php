<?php

/**
 * @var $title string
 * @var $user UserWeb
 */

use App\Common\Models\Catalog\Document\DocumentOrder;use App\Common\Models\User\UserWeb;

$success = session('success', '');
$orders = DocumentOrder::getAllByUser($user->id)
?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <div class="container user-page mb-5 mt-5">
        <div class="row">
            <div class="col-lg-4">
                <aside class="user-info-wrapper">
                    <div class="user-cover">
                        <div class="info-label"></div>
                    </div>
                    <div class="user-info">
                        <div class="user-avatar"><a class="edit-avatar" href="#"></a>
                            <img src="<?= $user->avatar() ?>" alt="User">
                        </div>
                        <div class="user-data">
                            <h4 class="h5"><?= $user->first_name ?> <?= $user->last_name ?></h4>
                            <span>Присоединился</span>
                            <span><?= date('d.m.Y H:i', $user->created_at) ?></span>
                            <?php if($user->isActive()){ ?>
                            <span class="badge badge-success">Подтвержден</span>
                            <?php }else{ ?>
                            <span class="badge badge-danger">Не подтвержден</span>
                            <?php } ?>
                        </div>
                    </div>
                </aside>
                <nav class="list-group">
                    <a
                        class="list-group-item"
                        id="v-pills-activate-tab"
                        data-toggle="pill"
                        href="#v-pills-activate"
                        role="tab"
                        aria-controls="v-pills-activate"
                        aria-selected="true">Активация</a>
                    <a
                        class="list-group-item active"
                        id="v-pills-home-tab"
                        data-toggle="pill"
                        href="#v-pills-home"
                        role="tab"
                        aria-controls="v-pills-home"
                        aria-selected="true">Профиль</a>
                    <a class="list-group-item" id="v-pills-address-tab" data-toggle="pill" href="#v-pills-address"
                       role="tab" aria-controls="v-pills-address" aria-selected="true">Адрес</a>
                    <a class="list-group-item" id="v-pills-security-tab" data-toggle="pill" href="#v-pills-security"
                       role="tab" aria-controls="v-pills-security" aria-selected="true">Безопасность</a>
                    <a class="list-group-item" id="v-pills-favorites-tab" data-toggle="pill" href="#v-pills-favorites"
                       role="tab" aria-controls="v-pills-favorites" aria-selected="true">Избранное</a>
                    <a class="list-group-item" id="v-pills-purchases-tab" data-toggle="pill" href="#v-pills-purchases"
                       role="tab" aria-controls="v-pills-purchases" aria-selected="true">Покупки</a>
                    <a class="list-group-item" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages"
                       role="tab" aria-controls="v-pills-messages" aria-selected="true">Сообщения</a>
                    <?php if($user->isAdmin()){ ?>
                    <a class="list-group-item" href="/admin">Админка</a>
                    <?php } ?>
                    <a class="list-group-item" href="/user/logout">Выйти</a>
                </nav>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="tab-content card-body" id="v-pills-tabContent">
                        <div class="tab-pane fade" id="v-pills-activate" role="tabpanel"
                             aria-labelledby="v-pills-activate-tab">
                            <form class="row big">
                                <div class="col-md-12">
                                    <h5>Активация аккаунта</h5>
                                    <hr class="padding-bottom-1x">
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="account-email">Активировать по E-mail</label>
                                                <input class="form-control" type="email" name="email" id="account-email"
                                                       value="<?= $user->email ?>"
                                                <?= $user->email ? 'disabled' : '' ?>>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group center">
                                                <?php if($user->is_email){ ?>
                                                <button
                                                    class="btn btn-outline-success"
                                                    type="button" disabled>Активировано
                                                </button>
                                                <?php }else{ ?>
                                                <a
                                                    href="/user/activate"
                                                    class="btn btn-outline-primary"
                                                    type="button">Активировать
                                                </a>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="account-phone">Активировать по телефону</label>
                                                <input
                                                    class="form-control"
                                                    type="text" id="account-phone"
                                                    name="activate_phone"
                                                    data-synchronization="phone"
                                                    value="<?= $user->getPhone() ?>" <?= $user->getPhone() ? 'disabled' : '' ?>>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group center">
                                                <?php if($user->is_phone){ ?>
                                                <button
                                                    class="btn btn-outline-success"
                                                    type="button" disabled>Активировано
                                                </button>
                                                <?php }else{ ?>
                                                <a
                                                    href="javascript:void(0)"
                                                    class="btn btn-outline-primary js-user-phone-activate-button"
                                                    type="button">Активировать
                                                </a>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                             aria-labelledby="v-pills-home-tab">
                            <form class="row big">
                                <div class="col-md-12">
                                    <h5>Общая информация</h5>
                                    <hr class="padding-bottom-1x">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account-email">E-mail</label>
                                        <input
                                            class="form-control"
                                            type="email"
                                            id="account-email"
                                            name="email"
                                            value="<?= $user->email ?>"
                                        <?= $user->email ? 'disabled' : '' ?>>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account-phone">Телефон</label>
                                        <input class="form-control"
                                               type="text"
                                               id="account-phone"
                                               name="phone"
                                               value="<?= $user->getPhone() ?>"
                                        <?= $user->getPhone() ? 'disabled' : '' ?>>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account-fn">Имя</label>
                                        <input class="form-control" type="text" id="account-fn"
                                               value="<?= $user->first_name ?>" required="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account-ln">Фамилия</label>
                                        <input class="form-control" type="text" id="account-ln"
                                               value="<?= $user->last_name ?>" required="">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr class="mt-2 mb-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <button class="btn btn-outline-primary margin-right-none" type="button">Обновить
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-address" role="tabpanel"
                             aria-labelledby="v-pills-address-tab">
                            <div class="col-md-12">
                                <h5>Адресы</h5>
                                <hr class="padding-bottom-1x">
                            </div>
                            <div class="col-12">
                                <hr class="mt-2 mb-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <button class="btn btn-outline-primary margin-right-none" type="button">Обновить
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-security" role="tabpanel"
                             aria-labelledby="v-pills-security-tab">
                            <form class="row big">
                                <div class="col-md-12">
                                    <h5>Сброс пароля</h5>
                                    <hr class="padding-bottom-1x">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="account-pass">Новый пароль</label>
                                        <input class="form-control" type="password" id="account-pass">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="account-confirm-pass">Повтор нового пароля</label>
                                        <input class="form-control" type="password" id="account-confirm-pass">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr class="mt-2 mb-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <button class="btn btn-outline-primary margin-right-none" type="button">Обновить
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-favorites" role="tabpanel"
                             aria-labelledby="v-pills-favorites-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Общая информация</h5>
                                    <hr class="padding-bottom-1x">
                                </div>
                                <div class="col-12">
                                    <hr class="mt-2 mb-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <button class="btn btn-outline-primary margin-right-none" type="button">Обновить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-purchases" role="tabpanel"
                             aria-labelledby="v-pills-purchases-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Список заказов</h5>
                                </div>
                                <div class="col-12">
                                    <ul class="list-group list-group-sm list-group-example mb-3">
                                        <?php if(isset($orders) && count($orders)){ ?>
                                        <?php foreach ($orders as $order){ ?>
                                            <li class="list-group-item">
                                                <a href="/user/order-pay-confirm?order=<?= $order->uuid ?>">
                                                    <strong>Заказ №: <?= $order->id ?></strong>
                                                    <span class="text-secondary"> от <?= _unix_to_string_moscow($order->created_at) ?></span>
                                                    <span class="text-secondary"> Статус: <?= $order->payment_status ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul>
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <button class="btn btn-outline-primary margin-right-none" type="button">Обновить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                             aria-labelledby="v-pills-messages-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Общая информация</h5>
                                    <hr class="padding-bottom-1x">
                                </div>
                                <div class="col-12">
                                    <hr class="mt-2 mb-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <button class="btn btn-outline-primary margin-right-none" type="button">Обновить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
