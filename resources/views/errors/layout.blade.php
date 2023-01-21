<?php

use App\Common\Assets\MainAsset;
use App\Common\Widgets\Analytics;

?>
        <!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?= _frontend_css($style ?? 'main') ?>
    <title><?= config('app.company_name') ?> | <?= $title ?? '' ?></title>
</head>
<body class="a-shop">
<?= Analytics::widget() ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light position-relative header__navbar">
        <a class="navbar-brand position-absolute header__logo" href="/">
            <img class="logo__image" src="<?=  MainAsset::img('FurSie_logo.png') ?>" alt="">
        </a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</header>
@include('errors.errors')
@yield('content')
<footer>
    <div class="footer__container">
        <a class="footer__logo" href="/">
            <img class="footer__logo-image" src="<?=  MainAsset::img('FurSie_logo.png') ?>" alt="">
        </a>
        <div class="footer__menu">
            <div class="socials">
                <a href="https://wa.me/79284252522?text=Здравствуйте!%20У%20меня%20вопрос." target="_blank"
                   rel="noopener noreferrer">
                    <img class="alignnone size-medium wp-image-631 alignright"
                         src="<?=  MainAsset::img('whatsapp.svg') ?>" alt="ссылка на Whatsapp" width="30"
                         height="30">
                </a>
                <a href="https://vk.com/fur_sie_2020" target="_blank" rel="noopener noreferrer">
                    <img class="alignnone size-medium wp-image-631 alignright"
                         src="<?=  MainAsset::img('VK_logo.svg') ?>" alt="ссылка на VK" width="30" height="30">
                </a>
                <a href="https://t.me/FuR_SiE_2020" target="_blank" rel="noopener noreferrer">
                    <img class="alignnone size-medium wp-image-630 alignright"
                         src="<?=  MainAsset::img('telegram.svg') ?>" alt="ссылка на telegram" width="30"
                         height="30">
                </a>
            </div>
            <div class="row">
                <div class="col-md-6 footer__requisites">
                    <p>ИП Семенова Ирина Владимировна</p>
                    <p>ИНН: 235207950556 ОГРН: 314234811300075</p>
                    <p>Юр. адрес/Факт. адрес: 350904, г.Краснодар, х.Копанской, ул.Уренгойская.</p>
                </div>
                <div class="col-md-6">
                    <p>
                        логотип | Семенова Ирина Владимировна<br>
                        все фотографии и права защищены | Семенова Ирина Владимировна<br>
                        2022
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<?= _frontend_js($script ?? 'main') ?>
</body>
</html>
