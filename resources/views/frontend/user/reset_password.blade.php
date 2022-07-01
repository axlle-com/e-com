<?php

/**
 * @var $title string
 * @var $user UserWeb
 */

use App\Common\Models\User\UserWeb;

$success = session('success', '');
?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <form action="/user/ajax/change-password">
    <div class="container user-page mb-5 mt-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="login_input">Пароль</label>
                    <input type="password"
                           class="form-control"
                           id="login_input"
                           data-validator-required
                           data-validator="password" name="password">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="login_input">Повторите пароль</label>
                    <input type="password"
                           class="form-control"
                           id="login_input"
                           data-validator-required
                           data-validator="password_confirmation"
                           name="password_confirmation">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <button class="btn btn-outline-primary margin-right-none js-change-password" type="button">Отправить
                    </button>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection
