<?php

use App\Common\Widgets\BasketWidget;

$page = _active_home_page();
//$p = CatalogProduct::query()
//    ->select([
//        CatalogProduct::table().'.*',
//        DB::raw('(select sum(s.quantity) as sum from ax_catalog_storage as s where s.catalog_product_id=ax_catalog_product.id group by s.catalog_product_id) as quantity')
//    ])
//    ->get();
//dd($p);
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="<?= _frontend('css/main.css') ?>">
    <?= empty($style) ? '' : '<link rel="stylesheet" href="' . $style . '">' ?>
        <link rel="stylesheet" href="<?= _frontend('css/common.css') ?>">
    <title><?= config('app.company_name') ?> | <?= $title ?? '' ?></title>
</head>
<body class="a-shop">
<header>
    <!-- modals -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="nav-item">
                            <a class="nav-link active" href="#loginTab" role="tab" data-toggle="tab" aria-controls="home" aria-selected="true">
                                Вход
                            </a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a class="nav-link" href="#registrationTab" role="tab" data-toggle="tab" aria-controls="profile" aria-selected="false">
                                Регистрация
                            </a>
                        </li>
                    </ul>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="1" y1="-1" x2="21.1537" y2="-1" transform="matrix(0.691658 0.722226 -0.691658 0.722226 1 2)"
                                  stroke="#007bff" stroke-width="2" stroke-linecap="round"/>
                            <line x1="1" y1="-1" x2="21.1537" y2="-1" transform="matrix(-0.691658 0.722226 0.691658 0.722226 17 2)"
                                  stroke="#007bff" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="loginTab">
                            <form class="form-horizontal" action="/user/ajax/login">
                                <div class="form-group">
                                    <label for="loginInput">Логин</label>
                                    <input type="text" class="form-control" id="loginInput" data-validator-required data-validator="login" name="login">
                                </div>
                                <div class="form-group">
                                    <label for="loginPassInput">Пароль</label>
                                    <input type="password" class="form-control" id="loginPassInput" data-validator-required data-validator="password" name="password">
                                    <div class="form-group forgot-pass">
                                        <a>Забыли пароль?</a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <input class="form__checkbox" type="checkbox" value="" id="loginCheckbox">
                                        <label for="loginCheckbox">
                                            Запомнить меня
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <a class="btn btn-outline-default js-user-submit-button">Войти</a>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="registrationTab">
                            <form class="form-horizontal" action="/user/ajax/registration">
                                <div class="form-group">
                                    <label for="register_first_name">Имя</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="register_first_name"
                                        name="first_name"
                                        data-validator-required
                                        data-validator="first_name">
                                </div>
                                <div class="form-group">
                                    <label for="register_last_name">Фамилия</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="register_last_name"
                                        name="last_name"
                                        data-validator-required
                                        data-validator="last_name">
                                </div>
                                <div class="form-group">
                                    <label for="register_phone_input">Номер телефона</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        class="form-control"
                                        id="register_phone_input"
                                        data-validator="phone">
                                </div>
                                <div class="form-group">
                                    <label for="registerEmailInput">Почта</label>
                                    <input
                                        type="email"
                                        name="email"
                                        value=""
                                        class="form-control"
                                        id="registerEmailInput"
                                        data-validator="email">
                                </div>
                                <div class="form-group">
                                    <label for="registerPassInput">Пароль</label>
                                    <input
                                        type="password"
                                        name="password"
                                        value=""
                                        class="form-control"
                                        id="registerPassInput"
                                        data-validator-required
                                        data-validator="password">
                                </div>
                                <div class="form-group">
                                    <label for="registerPassInput">Повторите пароль</label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        value=""
                                        class="form-control"
                                        id="registerPassInput"
                                        data-validator-required
                                        data-validator="password_confirmation">
                                </div>
                                <div class="form-group">
                                    <a class="btn btn-outline-default js-user-submit-button">
                                        Зарегистрироваться
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light position-relative header__navbar">
        <a class="navbar-brand position-absolute header__logo" href="/">
            <img class="logo__image" src="<?= _frontend('/assets/img/FurSie_logo.png') ?>" alt="">
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
{{--                <li class="nav-item <?= $page['catalog'] ?? '' ?>">--}}
{{--                    <a class="nav-link" href="/catalog">Магазин</a>--}}
{{--                </li>--}}
                <li class="nav-item <?= $page['contact'] ?? '' ?>">
                    <a class="nav-link" href="/contact">Контакты</a>
                </li>
            </ul>
        </div>

        <div class="header__navbar_right-wrap toolbar-item js-block-mini-basket">
            <a href="#" class="header__login-link"  data-toggle="modal" data-target="#authModal">
                <svg aria-hidden="true" focusable="false" class="header__login-icon" viewBox="0 0 28.33 37.68">
                    <path
                        d="M14.17 14.9a7.45 7.45 0 1 0-7.5-7.45 7.46 7.46 0 0 0 7.5 7.45zm0-10.91a3.45 3.45 0 1 1-3.5 3.46A3.46 3.46 0 0 1 14.17 4zM14.17 16.47A14.18 14.18 0 0 0 0 30.68c0 1.41.66 4 5.11 5.66a27.17 27.17 0 0 0 9.06 1.34c6.54 0 14.17-1.84 14.17-7a14.18 14.18 0 0 0-14.17-14.21zm0 17.21c-6.3 0-10.17-1.77-10.17-3a10.17 10.17 0 1 1 20.33 0c.01 1.23-3.86 3-10.16 3z">
                    </path>
                </svg>
            </a>
            <?= BasketWidget::widget()?>
        </div>
    </nav>
</header>
@yield('content')
<footer>
    <div class="footer__container">
        <a class="footer__logo" href="/">
            <img class="footer__logo-image" src="<?= _frontend('/assets/img/FurSie_logo.png') ?>" alt="">
        </a>
        <div class="footer__menu">
            <div class="socials">
                <a href="https://wa.me/79284252522?text=Здравствуйте!%20У%20меня%20вопрос." target="_blank"
                   rel="noopener noreferrer">
                    <img class="alignnone size-medium wp-image-631 alignright"
                         src="<?= _frontend('/assets/img/whatsapp.svg') ?>" alt="ссылка на Whatsapp" width="30"
                         height="30">
                </a>
                <a href="https://vk.com/fur_sie_2020" target="_blank" rel="noopener noreferrer">
                    <img class="alignnone size-medium wp-image-631 alignright"
                         src="<?= _frontend('/assets/img/VK_logo.svg') ?>" alt="ссылка на VK" width="30" height="30">
                </a>
                <a href="https://t.me/FuR_SiE_2020" target="_blank" rel="noopener noreferrer">
                    <img class="alignnone size-medium wp-image-630 alignright"
                         src="<?= _frontend('/assets/img/telegram.svg') ?>" alt="ссылка на telegram" width="30"
                         height="30">
                </a>
            </div>
            <p>
                логотип | Семенова Ирина Владимировна<br>
                все права защищены и фотография | Семенова Ирина Владимировна<br>
                2022
            </p>
        </div>
    </div>
</footer>
<script src="<?= _frontend('js/main.js') ?>"></script>
<?= empty($script) ? '' : '<script src="' . $script . '"></script>' ?>
<script src="<?= _frontend('js/common.js') ?>"></script>
</body>
</html>
