<?php
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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= ax_frontend('css/main.css') ?>">
    <link rel="stylesheet" href="<?= ax_frontend('css/common.css') ?>">
    <title><?= config('app.company_name') ?> | <?= $title ?? '' ?></title>
</head>
<body class="a-shop">
{{--@if (Route::has('login'))--}}
{{--    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">--}}
{{--        @auth--}}
{{--            <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>--}}
{{--            <a href="{{ url('/admin') }}" class="text-sm text-gray-700 underline">Admin</a>--}}
{{--        @else--}}
{{--            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>--}}
{{--            @if (Route::has('register'))--}}
{{--                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>--}}
{{--            @endif--}}
{{--        @endauth--}}
{{--    </div>--}}
{{--@endif--}}
    <header>
        <nav class="navbar navbar-expand-lg navbar-light position-relative header__navbar">
            <a class="navbar-brand position-absolute header__logo" href="index.html">
                <img class="logo__image" src="<?= ax_frontend('/assets/img/FurSie_logo.png') ?>" alt="">
            </a>

            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse header__navbar-container" id="navbarsExampleDefault" style="">
                <ul class="navbar-nav m-auto header__menu">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">Главная<span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="history.html">История</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="blog.html">Блог</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="portfolio.html">Портфолио</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" href="shop.html" id="dropdown01" aria-expanded="false">
                            Магазин
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="shop.html">Магазин</a>
                            <a class="dropdown-item" href="product_card.html">Демо карточки товара</a>
                            <a class="dropdown-item" href="#">Что-то ещё</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Контакты</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    @yield('content')
    <footer>
        <div class="footer__container">
            <div class="socials">
                <a href="https://nl.pinterest.com/mikevermeij" target="_blank" rel="noopener noreferrer">
                    <img class="alignnone size-medium wp-image-631 alignright" src="https://michaelvermeij.com/wp-content/uploads/pin.png" alt="" width="45" height="45">
                </a>

                <a href="http://www.instagram.com/handcrafted.design" target="_blank" rel="noopener noreferrer">
                    <img class="alignnone size-medium wp-image-630 alignright" src="https://michaelvermeij.com/wp-content/uploads/inst.png" alt="" width="45" height="45">
                </a>

                <a href="http://www.etsy.com/shop/MichaelVermeij" target="_blank" rel="noopener noreferrer">
                    <img class="alignnone size-full wp-image-628 alignright" src="https://michaelvermeij.com/wp-content/uploads/ets.png" alt="" width="44" height="45">
                </a>
            </div>

            <div class="footer__menu"><p>&nbsp;</p>
                <p style="text-align: right; line-height: 25px">
                    logo &amp; webdesign | Vincent van de Haar<br>
                    all rights reserved &amp; photography&nbsp;| Michael Vermeij<br>
                    video |<a href="https://www.firehorsephotographyfrance.com/"> Firehorse Films</a><br>
                    &nbsp; <br>
                    <a href="https://michaelvermeij.com/privacy-policy">privacy policy</a>&nbsp;<br>
                    siret; 82907682700023
                </p>
            </div>
        </div>
    </footer>
    <script src="<?= ax_frontend('js/main.js') ?>"></script>
    <script src="<?= ax_frontend('js/common.js') ?>"></script>
</body>
</html>
