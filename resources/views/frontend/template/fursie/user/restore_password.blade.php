<?php

use App\Common\Models\Setting\Setting;
use App\Common\Models\User\UserWeb;

$template = Setting::template();

/**
 * @var $title string
 * @var $user UserWeb
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <form action="/user/ajax/restore-password">
        <div class="container user-page mb-5 mt-5">
            <div class="row">
                <div class="col-sm-6">
                    <p>Укажите ваш E-mail, который вы указывали при регистрации</p>
                    <div class="form-group">
                        <label for="login_input">E-mail</label>
                        <input type="text"
                               class="form-control"
                               id="login_input"
                               data-validator-required
                               data-validator="email" name="email">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <button class="btn btn-outline-primary margin-right-none js-restore-password" type="button">
                            Отправить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
