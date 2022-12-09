<?php

use App\Common\Widgets\Analytics;
use App\Common\Models\User\UserWeb;
use App\Common\Assets\MainAsset;
use App\Common\Models\Telegram\TelegramService;
$t = \App\Common\Models\Setting\Setting::model()->getTelegramBotToken();
_dd_($t);
/**
 * @var UserWeb $user
 */
TelegramService::model()->update();
$menu = [
    [
        'href' => '/',
        'title' => 'Главная',
    ],
    [
        'href' => '/about',
        'title' => 'Обо мне',
    ],
    [
        'href' => '/service',
        'title' => 'Услуги',
    ],
    [
        'href' => '/blog',
        'title' => 'Блог',
    ],
    [
        'href' => '/contact',
        'title' => 'Контакты',
    ],
];
$page = _active_front_page($menu);

$config = [
    'name' => config('app.company_name'),
    'title' => $title ?? '',
    'file' => $style ?? 'main',
];

$asset = MainAsset::model($config);

?>
        <!doctype html>
<html lang="ru">
<?= $asset->head(); ?>
<body class="a-shop">
<?= Analytics::widget() ?>
@include('errors.errors')
<!-- PRELOADER -->
<div id="preloader">
    <div class="loader_line"></div>
</div>
<!-- /PRELOADER -->
<!-- WRAPPER ALL -->
<div class="tokyo_tm_all_wrap" data-magic-cursor="show" data-enter="fadeInLeft" data-exit="">
    <!-- MOBILE MENU -->
    <div class="tokyo_tm_topbar">
        <div class="topbar_inner">
            <div class="logo" data-type="image">
                <!-- You can use image or text as logo. data-type values are "image" and "text" -->
                <a href="#">
                    <img src="<?= _frontend_img('/logo/dark.png') ?>" alt="">
                    <h3>YASOKOLOV</h3>
                </a>
            </div>
            <div class="trigger">
                <div class="hamburger hamburger--slider">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tokyo_tm_mobile_menu">
        <div class="menu_list">
            <ul class="transition_link"><?= $page ?></ul>
        </div>
    </div>
    <!-- /MOBILE MENU -->
    <!-- LEFTPART -->
    <div class="leftpart">
        <div class="leftpart_inner">
            <div class="logo" data-type="image">
                <a href="#">
                    <img src="<?= _frontend_img('/logo/dark.png') ?>" alt=""/>
                    <h3>TOKYO</h3>
                </a>
            </div>
            <div class="menu">
                <ul class="transition_link"><?= $page ?></ul>
            </div>
            <div class="copyright">
                <p>&copy; 2022 Tokyo<br>Created by <a href="https://themeforest.net/user/marketify" target="_blank">Marketify</a>
                </p>
            </div>
        </div>
    </div>
    <!-- /LEFTPART -->
    <div class="rightpart">
        <div class="rightpart_in">
            @yield('content')
        </div>
    </div>
    <!-- CURSOR -->
    <div class="mouse-cursor cursor-outer"></div>
    <div class="mouse-cursor cursor-inner"></div>
    <!-- /CURSOR -->
</div>
<!-- / WRAPPER ALL -->
<?= $asset->js() ?>
</body>
</html>
