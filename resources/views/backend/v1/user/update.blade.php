<?php

use App\Common\Models\Setting\Setting;
use App\Common\Models\User\UserWeb;




/** @var $title string
 * @var $model UserWeb
 */

$title = $title ?? 'Новый сотрудник'

?>
@extends($layout,['title' => $title])

@section('content')
    <div class="main-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style3">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
        <h5><?= $title ?></h5>
        <div class="js-user">
            <form id="user-form" action="/admin/user/ajax/save">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-with-gap mb-2">
                                    <button type="button" class="btn btn-success js-user-save-button">Сохранить
                                    </button>
                                    <a type="button" class="btn btn-secondary" href="/admin">Выйти</a>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <fieldset class="form-block">
                                            <legend>Изображение</legend>
                                            @include($backendTemplate.'.inc.image', ['url' => $model->getImage(),'model' => $model])
                                            <div class="form-group">
                                                <label class="control-label button-100" for="js-image-upload">
                                                    <a type="button" class="btn btn-primary button-image">Загрузить
                                                        фото</a>
                                                </label>
                                                <input
                                                        type="file"
                                                        id="js-image-upload"
                                                        class="custom-input-file js-image-upload"
                                                        name="image"
                                                        accept="image/*">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="name">Имя</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="Имя"
                                                            name="first_name"
                                                            id="first_name"
                                                            value="<?= $model->first_name ?>"
                                                            data-validator="first_name">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="name_full">Отчество</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="Отчество"
                                                            name="patronymic"
                                                            id="patronymic"
                                                            value="<?= $model->patronymic ?>"
                                                            data-validator="patronymic">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="site">Фамилия</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="Фамилия"
                                                            name="last_name"
                                                            id="last_name"
                                                            value="<?= $model->last_name ?>"
                                                            data-validator="last_name">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="email">E-mail</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="E-mail"
                                                            name="email"
                                                            id="email"
                                                            value="<?= $model->email ?>"
                                                            data-validator="email">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="email">E-mail</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="Телефон"
                                                            name="phone"
                                                            id="phone"
                                                            value="<?= _pretty_phone($model->phone) ?>"
                                                            data-validator="phone">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="site">Пароль</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="Пароль"
                                                            name="password"
                                                            type="password"
                                                            id="password"
                                                            value="<?= $model->password ?>"
                                                            data-validator="password">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="site">Повторите пароль</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="Повторите пароль"
                                                            name="password_confirmation"
                                                            type="password"
                                                            id="password_confirmation"
                                                            value="<?= $model->password_confirmation ?>"
                                                            data-validator="password_confirmation">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
