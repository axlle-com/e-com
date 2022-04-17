<?php
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

        <div class="header__navbar_right-wrap toolbar-item">
            <a href="#" class="header__login-link">
                <svg aria-hidden="true" focusable="false" class="header__login-icon" viewBox="0 0 28.33 37.68">
                    <path
                        d="M14.17 14.9a7.45 7.45 0 1 0-7.5-7.45 7.46 7.46 0 0 0 7.5 7.45zm0-10.91a3.45 3.45 0 1 1-3.5 3.46A3.46 3.46 0 0 1 14.17 4zM14.17 16.47A14.18 14.18 0 0 0 0 30.68c0 1.41.66 4 5.11 5.66a27.17 27.17 0 0 0 9.06 1.34c6.54 0 14.17-1.84 14.17-7a14.18 14.18 0 0 0-14.17-14.21zm0 17.21c-6.3 0-10.17-1.77-10.17-3a10.17 10.17 0 1 1 20.33 0c.01 1.23-3.86 3-10.16 3z">
                    </path>
                </svg>
            </a>
            <a href="/catalog/basket" class="header__cart-link">
                <svg class="header__cart-icon" viewBox="0 0 37 40">
                    <path
                        d="M36.5 34.8L33.3 8h-5.9C26.7 3.9 23 .8 18.5.8S10.3 3.9 9.6 8H3.7L.5 34.8c-.2 1.5.4 2.4.9 3 .5.5 1.4 1.2 3.1 1.2h28c1.3 0 2.4-.4 3.1-1.3.7-.7 1-1.8.9-2.9zm-18-30c2.2 0 4.1 1.4 4.7 3.2h-9.5c.7-1.9 2.6-3.2 4.8-3.2zM4.5 35l2.8-23h2.2v3c0 1.1.9 2 2 2s2-.9 2-2v-3h10v3c0 1.1.9 2 2 2s2-.9 2-2v-3h2.2l2.8 23h-28z">
                    </path>
                </svg>
                <div id="CartCount" class="header__cart-counter" data-cart-count-bubble="">
                    <span data-cart-count="">0</span>
                </div>
            </a>
            <div class="toolbar-dropdown cart-dropdown widget-cart js-block-mini-basket">
                <div class="entry">
                    <div class="entry-thumb"><a href="shop-single.html"><img src="/upload/ax_catalog_product/razdelochnaya-doska-1/EmwiAfGRAj0hsOYnpisdZUQFY4wmP2rY1M3J599L.jpeg" alt="Product"></a></div>
                    <div class="entry-content">
                        <h4 class="entry-title"><a href="shop-single.html">Canon EOS M50 Mirrorless Camera</a></h4><span class="entry-meta">1 x $910.00</span>
                    </div>
                    <div class="entry-delete"><i class="icon-x"></i></div>
                </div>
                <div class="entry">
                    <div class="entry-thumb"><a href="shop-single.html"><img src="/upload/ax_catalog_product/razdelochnaya-doska-1/EmwiAfGRAj0hsOYnpisdZUQFY4wmP2rY1M3J599L.jpeg" alt="Product"></a></div>
                    <div class="entry-content">
                        <h4 class="entry-title"><a href="shop-single.html">Apple iPhone X 256 GB Space Gray</a></h4><span class="entry-meta">1 x $1,450.00</span>
                    </div>
                    <div class="entry-delete"><i class="icon-x"></i></div>
                </div>
                <div class="entry">
                    <div class="entry-thumb"><a href="shop-single.html"><img src="/upload/ax_catalog_product/razdelochnaya-doska-1/EmwiAfGRAj0hsOYnpisdZUQFY4wmP2rY1M3J599L.jpeg" alt="Product"></a></div>
                    <div class="entry-content">
                        <h4 class="entry-title"><a href="shop-single.html">HP LaserJet Pro Laser Printer</a></h4><span class="entry-meta">1 x $188.50</span>
                    </div>
                    <div class="entry-delete"><i class="icon-x"></i></div>
                </div>
                <div class="text-right">
                    <p class="text-gray-dark py-2 mb-0"><span class="text-muted">Итого:</span> &nbsp;$2,548.50</p>
                </div>
                <div class="d-flex">
                    <div class="pr-2 w-50"><a class="btn btn-outline-secondary btn-sm btn-block mb-0" href="">Очистить</a></div>
                    <div class="pl-2 w-50"><a class="btn btn-outline-primary btn-sm btn-block mb-0" href="/catalog/basket">Оформить</a></div>
                </div>
            </div>
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
