<?php
$page = ax_active_home_page();

var_dump(empty(''));
?>
    <!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="<?= ax_frontend('css/main.css') ?>">
{{--    <link rel="stylesheet" href="<?= ax_frontend('css/common.css') ?>">--}}
    <title><?= config('app.company_name') ?> | <?= $title ?? '' ?></title>
</head>
<body class="a-shop">
<header>
    <nav class="navbar navbar-expand-lg navbar-light position-relative header__navbar">
        <a class="navbar-brand position-absolute header__logo" href="index.html">
            <img class="logo__image" src="<?= ax_frontend('/assets/img/FurSie_logo.png') ?>" alt="">
        </a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse header__navbar-container" id="navbarsExampleDefault" style="">
            <ul class="navbar-nav m-auto header__menu">
                <li class="nav-item <?= $page['home'] ?? '' ?>">
                    <a class="nav-link" href="/">Главная<span class="sr-only"></span></a>
                </li>
                <li class="nav-item <?= $page['history'] ?? '' ?>">
                    <a class="nav-link" href="/history">История</a>
                </li>
                <li class="nav-item <?= $page['blog'] ?? '' ?>">
                    <a class="nav-link" href="javascript:void(0);">Блог</a>
                </li>
                <li class="nav-item <?= $page['portfolio'] ?? '' ?>">
                    <a class="nav-link" href="/portfolio">Портфолио</a>
                </li>
                <li class="nav-item <?= $page['contact'] ?? '' ?>">
                    <a class="nav-link" href="/contact">Контакты</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
@yield('content')
<footer>
    <div class="footer__container">
        <div class="socials">
            <a href="https://vk.com/fur_sie_2020" target="_blank" rel="noopener noreferrer">
                <img class="alignnone size-medium wp-image-631 alignright"
                     src="<?= ax_frontend('/assets/img/VK_logo.svg') ?>" alt="ссылка на VK" width="30" height="30">
            </a>

            <a href="https://t.me/FuR_SiE_2020" target="_blank" rel="noopener noreferrer">
                <img class="alignnone size-medium wp-image-630 alignright"
                     src="<?= ax_frontend('/assets/img/telegram.svg') ?>" alt="ссылка на telegram" width="30"
                     height="30">
            </a>
        </div>

        <div class="footer__menu"><p>&nbsp;</p>
            <p style="text-align: right; line-height: 25px">
                логотип | Семенова Ирина Владимировна<br>
                все права защищены и фотография | Семенова Ирина Владимировна<br>
                2022
            </p>
        </div>
    </div>
</footer>
<script src="<?= ax_frontend('js/main.js') ?>"></script>
{{--<script src="<?= ax_frontend('js/common.js') ?>"></script>--}}
</body>
</html>
