<?php

/**
 * @var $title string
 * @var $user UserWeb
 */

use App\Common\Models\User\UserWeb;

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <div class="container user-page padding-bottom-3x mb-5 mt-5">
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
                            <span><?= date('d.m.Y H:i',$user->created_at) ?></span>
                            <?php if($user->isActive()){ ?>
                                <span class="badge badge-success">Подтвержден</span>
                            <?php }else{ ?>
                                <span class="badge badge-danger">Не подтвержден</span>
                            <?php } ?>
                        </div>
                    </div>
                </aside>
                <nav class="list-group">
                    <?php if(!$user->isActive()){ ?>
                        <a
                            class="list-group-item active"
                            id="v-pills-activate-tab"
                            data-toggle="pill"
                            href="#v-pills-activate"
                            role="tab"
                            aria-controls="v-pills-activate"
                            aria-selected="true">Активация</a>
                    <?php }else{ ?>
                        <a
                            class="list-group-item active"
                            id="v-pills-home-tab"
                            data-toggle="pill"
                            href="#v-pills-home"
                            role="tab"
                            aria-controls="v-pills-home"
                            aria-selected="true">Профиль</a>
                    <?php } ?>
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
                    <a class="list-group-item" href="/user/logout">Выйти</a>
                </nav>
            </div>
            <div class="col-lg-8 card">
                <div class="tab-content card-body" id="v-pills-tabContent">
                    <?php if(!$user->isActive()){ ?>
                        <div class="tab-pane fade show active" id="v-pills-activate" role="tabpanel" aria-labelledby="v-pills-activate-tab">
                            <form class="row big">
                                <div class="col-md-12">
                                    <h5>Активация аккаунта</h5>
                                    <hr class="padding-bottom-1x">
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="account-email">Активировать по E-mail</label>
                                        <input class="form-control" type="email" id="account-email" value="<?= $user->email ?>" <?= $user->email ? 'disabled' : '' ?>>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="account-phone">Активировать по телефону</label>
                                        <input class="form-control" type="text" id="account-phone" value="<?= $user->phone() ?>" <?= $user->phone() ? 'disabled' : '' ?>>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php }else{ ?>
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <form class="row big">
                                <div class="col-md-12">
                                    <h5>Общая информация</h5>
                                    <hr class="padding-bottom-1x">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account-email">E-mail</label>
                                        <input class="form-control" type="email" id="account-email" value="<?= $user->email ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account-phone">Телефон</label>
                                        <input class="form-control" type="text" id="account-phone" value="<?= _pretty_phone($user->phone) ?>" required="" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account-fn">Имя</label>
                                        <input class="form-control" type="text" id="account-fn" value="<?= $user->first_name ?>" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account-ln">Фамилия</label>
                                        <input class="form-control" type="text" id="account-ln" value="<?= $user->last_name ?>" required="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr class="mt-2 mb-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <button class="btn btn-outline-primary margin-right-none" type="button">Обновить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                    <div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
                        <div class="col-md-12">
                            <h5>Адресы</h5>
                            <hr class="padding-bottom-1x">
                        </div>
                        <div class="col-12">
                            <hr class="mt-2 mb-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <button class="btn btn-outline-primary margin-right-none" type="button">Обновить</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-security" role="tabpanel" aria-labelledby="v-pills-security-tab">
                        <form class="row big">
                            <div class="col-md-12">
                                <h5>Сброс пароля</h5>
                                <hr class="padding-bottom-1x">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="account-pass">Новый пароль</label>
                                    <input class="form-control" type="password" id="account-pass">
                                </div>
                                <div class="form-group">
                                    <label for="account-confirm-pass">Повтор нового пароля</label>
                                    <input class="form-control" type="password" id="account-confirm-pass">
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="mt-2 mb-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <button class="btn btn-outline-primary margin-right-none" type="button">Обновить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="v-pills-favorites" role="tabpanel" aria-labelledby="v-pills-favorites-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Общая информация</h5>
                                <hr class="padding-bottom-1x">
                            </div>
                            <div class="col-12">
                                <hr class="mt-2 mb-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <button class="btn btn-outline-primary margin-right-none" type="button">Обновить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-purchases" role="tabpanel" aria-labelledby="v-pills-purchases-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Общая информация</h5>
                                <hr class="padding-bottom-1x">
                            </div>
                            <div class="col-12">
                                <hr class="mt-2 mb-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <button class="btn btn-outline-primary margin-right-none" type="button">Обновить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Общая информация</h5>
                                <hr class="padding-bottom-1x">
                            </div>
                            <div class="col-12">
                                <hr class="mt-2 mb-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <button class="btn btn-outline-primary margin-right-none" type="button">Обновить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
