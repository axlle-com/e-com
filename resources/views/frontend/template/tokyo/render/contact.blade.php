<?php

/**
 * @var $title string
 * @var $template string
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <div id="contact" class="tokyo_tm_section active animated fadeInLeft">
        <div class="container">
            <div class="tokyo_tm_contact">
                <div class="tokyo_tm_title">
                    <div class="title_flex">
                        <div class="left">
                            <span>Контакты</span>
                            <h3>КОНТАКТНАЯ ИНФОРМАЦИЯ</h3>
                            <div class="descriptions">
                                <p>8-931-312-2767</p>
                                <p>info@yasokolov.ru<p>
                                <p>Для корреспонденции<p>
                                <p>107014, г. Москва, а/я 124<p>
                                <p>Переговорная комната<p>
                                <p>г. Москва, ул. Бауманская, д. 33/2, строение 1, 3 этаж<p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fields">
                    <form action="/ajax/contact" method="post" class="contact_form" autocomplete="off">
                        <div class="returnmessage"></div>
                        <div class="first">
                            <ul>
                                <li>
                                    <input id="name" type="text" placeholder="Имя" name="name" data-validator-required>
                                    <div class="invalid-feedback"></div>
                                </li>
                                <li>
                                    <input id="email" type="text" placeholder="Email" name="email" data-validator-required>
                                    <div class="invalid-feedback"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="last">
                            <textarea id="message" placeholder="Message" name="body" data-validator-required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="tokyo_tm_button" data-position="left">
                            <a href="#">
                                <span class="form-send">Отправить</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
