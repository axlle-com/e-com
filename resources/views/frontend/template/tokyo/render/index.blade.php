<?php

use App\Common\Assets\MainAsset;

/**
 * @var $title string
 * @var $template string
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <div id="home" class="tokyo_tm_section active animated fadeInLeft">
        <div class="container">
            <div class="tokyo_tm_home">
                <div class="home_content">
                    <div class="img-home">
                        <img class="img-fluid" src="<?= MainAsset::img('/index.jpg') ?>">
                    </div>
                    <div class="details">
                        <h3 class="name">ЯКОВ <span>СОКОЛОВ</span></h3>
                        <p class="job">Адвокат по уголовным делам<br>Защищаю граждан и бизнес</p>
                        <p class="job-info">
                            Реестровый номер: 77/16399<br>
                            в Адвокатской палате города Москвы
                        </p>
                        <div class="social">
                            <ul>
                                <li>
                                    <a href="https://t.me/yasokolov_ru"><img src="/img/telegram.png"></a>
                                </li>
                                <li>
                                    <a href="https://api.whatsapp.com/send?phone=79313122767"><img
                                            src="/img/WhatsApp.png"></a>
                                </li>
                                <li>
                                    <a href="https://vk.com/yakov_sokolov"><img src="/img/vk_com.png"></a>
                                </li>
                                <li>
                                    <a href="https://zen.yandex.ru/id/6188abde0cc7925b488c1dc9">
                                        <img src="/img/zen_yandex.png">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
