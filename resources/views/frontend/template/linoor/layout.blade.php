<?php

use App\Common\Assets\MainAsset;
use App\Common\Models\User\UserWeb;
use App\Common\Widgets\Analytics;

/**
 * @var UserWeb $user
 */

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

<?= MainAsset::model()
    ->load($config)
    ->head() ?>

<body class="body-dark">
<div class="page-wrapper a-shop">
    <!-- Preloader -->
    <div class="preloader">
        <div class="icon"></div>
    </div>
    <!-- Main Header -->
    <header class="main-header header-style-one">

        <!-- Header Upper -->
        <div class="header-upper">
            <div class="inner-container clearfix">
                <!--Logo-->
                <div class="logo-box">
                    <div class="logo"><a href="/" title="Linoor - DIgital Agency HTML Template"><img
                                    src="/frontend/linoor/assets/img/logo.png" id="thm-logo" alt="Linoor - DIgital Agency HTML Template"
                                    title="Linoor - DIgital Agency HTML Template"></a></div>
                </div>
                <div class="nav-outer clearfix">
                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler"><span class="icon flaticon-menu-2"></span><span
                                class="txt">Menu</span></div>

                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md navbar-light">
                        <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                            <ul class="navigation clearfix">
                                <li class="dropdown megamenu megamenu-clickable megamenu-clickable--toggler">
                                    <a href="/uslugi">Home</a>
                                    <ul>
                                        <li>
                                            <section class="home-showcase">
                                                    <span class="home-showcase__toggler megamenu-clickable--toggler">
                                                        <a href="#" class="linoor-icon-two-close"></a>
                                                    </span><!-- /.home-showcase__toggler -->
                                                <div class="auto-container">
                                                    <div class="home-showcase__inner">

                                                        <h3 class="home-showcase__top-title">Pre-Built Demos
                                                        </h3>

                                                        <div class="row">

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-1.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">photography
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-2.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">design
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-3.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Profile
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-4.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">Multi
                                                                                            Page</span>
                                                                                </a>

                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">One
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Corporate
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-5.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">Multi
                                                                                            Page</span>
                                                                                </a>

                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">One
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Seo
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-6.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">Multi
                                                                                            Page</span>
                                                                                </a>

                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">One
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Consulting
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-7.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="/uslugi"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">Multi
                                                                                            Page</span>
                                                                                </a>

                                                                                <a href="index-4-one-page.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">One
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Business
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-8.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-5.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Digital
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-9.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-portfolio.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Portfolio</h3>
                                                                    <!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-10.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-parallax.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">Multi
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Parallax
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-11.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-main.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">agency 01
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-12.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-2.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">Multi
                                                                                            Page</span>
                                                                                </a>

                                                                                <a href="index-2-one-page.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">One
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">agency 02
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-13.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-3.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">Multi
                                                                                            Page</span>
                                                                                </a>

                                                                                <a href="index-3-one-page.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">One
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">agency 03</h3>
                                                                    <!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-14.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="one-page.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">One Page</h3>
                                                                    <!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-19.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-dark.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Dark</h3>
                                                                    <!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-3">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-16.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-boxed.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">Boxed
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-3 -->

                                                            <div class="col-lg-6">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-17.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-portfolio-2.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">horizontal
                                                                        01
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-6 -->

                                                            <div class="col-lg-6">
                                                                <div class="home-showcase__item">
                                                                    <div class="home-showcase__image-box">
                                                                        <div class="home-showcase__image">
                                                                            <img src="/frontend/linoor/assets/img/update-18-05-2022/home-showcase/home-showcase-1-18.jpg"
                                                                                 alt="">
                                                                            <div class="home-showcase__buttons">
                                                                                <a href="index-portfolio-3.html"
                                                                                   class="theme-btn btn-style-one home-showcase__buttons__item">
                                                                                    <i class="btn-curve"></i>
                                                                                    <span class="btn-title">View
                                                                                            Page</span>
                                                                                </a>
                                                                            </div>
                                                                            <!-- /.home-showcase__buttons -->
                                                                        </div><!-- /.home-showcase__image -->
                                                                    </div><!-- /.home-showcase__image box -->
                                                                    <h3 class="home-showcase__title">horizontal
                                                                        02
                                                                    </h3><!-- /.home-showcase__title -->
                                                                </div><!-- /.home-showcase__item -->
                                                            </div><!-- /.col-lg-6 -->

                                                        </div><!-- /.row -->
                                                    </div><!-- /.home-showcase__inner -->

                                                </div><!-- /.container -->
                                            </section>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="about.html">About Us</a>
                                    <ul>
                                        <li><a href="about-2.html">About Two </a></li>
                                        <li><a href="about-me.html">About Me </a></li>
                                        <li><a href="mission.html">Our Mission </a></li>
                                        <li><a href="history.html">Our History </a></li>
                                        <li class="dropdown">
                                            <a href="team.html">Our Team </a>
                                            <ul>
                                                <li><a href="team.html">Team 01</a></li>
                                                <li><a href="team-2.html">Team 02</a></li>
                                                <li><a href="team-3.html">Team 03</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="process.html">Our Process </a></li>
                                        <li><a href="partners.html">Our Partner</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#">Pages</a>
                                    <ul>
                                        <li><a href="pricing.html">Our Pricing </a></li>
                                        <li><a href="pricing-2.html">Pricing 02</a></li>
                                        <li><a href="how-it-works.html">How it Works </a></li>
                                        <li><a href="coming-soon.html">Coming Soon </a></li>
                                        <li><a href="testimonials.html">Testimonials</a></li>
                                        <li><a href="testimonials-2.html">Testimonials Two </a></li>
                                        <li><a href="faqs.html">FAQs</a></li>
                                        <li><a href="events.html">Events </a></li>
                                        <li><a href="event-details.html">Event Details </a></li>
                                        <li><a href="clients.html">Clients Page </a></li>
                                        <li><a href="not-found.html">404 Page</a></li>
                                        <li><a href="login.html">Login Page</a></li>
                                        <li><a href="register.html">Register Page</a></li>
                                        <li><a href="forgot-password.html">Forget Page</a></li>
                                        <li><a href="under-construction.html">Under Construction</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="services.html">Services</a>
                                    <ul>
                                        <li><a href="services.html">All Services</a></li>
                                        <li><a href="services-2.html">Services Two</a></li>
                                        <li><a href="web-development.html">Website Development</a></li>
                                        <li><a href="graphic-designing.html">Graphic Designing</a></li>
                                        <li><a href="digital-marketing.html">Digital Marketing</a></li>
                                        <li><a href="seo.html">SEO & Content Writting</a></li>
                                        <li><a href="app-development.html">App Development</a></li>
                                        <li><a href="ui-designing.html">UI/UX Designing</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="portfolio.html">Portfolio</a>
                                    <ul>
                                        <li><a href="portfolio.html">Portfolio</a></li>
                                        <li><a href="portfolio-2-columns.html">Portfolio 2 Col <span>new</span></a>
                                        </li>
                                        <li><a href="portfolio-4-columns.html">Portfolio 4 Col <span>new</span></a>
                                        </li>
                                        <li><a href="portfolio-masonary.html">Portfolio Masonary
                                                <span>new</span></a></li>
                                        <li><a href="portfolio-single.html">Portfolio Single 01</a></li>
                                        <li><a href="portfolio-single-2.html">Portfolio Single 02</a></li>
                                        <li><a href="portfolio-single-3.html">Portfolio Single 03
                                            </a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="shop.html">Shop</a>
                                    <ul>
                                        <li><a href="shop.html">Shop Page</a></li>
                                        <li><a href="product-details.html">Product Details</a></li>
                                        <li><a href="cart.html">Cart Page</a></li>
                                        <li><a href="checkout.html">Checkout Page</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="blog-grid.html">Blog</a>
                                    <ul>
                                        <li><a href="blog.html">Blog Right Sidebar</a></li>
                                        <li><a href="blog-left.html">Blog Left Sidebar <span>new</span></a></li>
                                        <li><a href="blog-grid.html">Blog Grid View</a></li>
                                        <li><a href="blog-single.html">Blog Single</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="contact.html">Contact</a>
                                    <ul>
                                        <li><a href="contact.html">Contact 01</a></li>
                                        <li><a href="contact-2.html">Contact 02 <span>New</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <div class="other-links clearfix">
                    <!-- cart btn -->
                    <div class="cart-btn">
                        <a href="cart.html" class="theme-btn cart-toggler"><span
                                    class="flaticon-shopping-cart"></span></a>
                    </div>
                    <!--Search Btn-->
                    <div class="search-btn">
                        <button type="button" class="theme-btn search-toggler"><span
                                    class="flaticon-loupe"></span></button>
                    </div>
                    <div class="link-box">
                        <div class="call-us">
                            <a class="link" href="tel:6668880000">
                                <span class="icon"></span>
                                <span class="sub-text">Call Anytime</span>
                                <span class="number">666 888 0000</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--End Header Upper-->

    </header>
    <!-- End Main Header -->
    <!--Mobile Menu-->
    <div class="side-menu__block">


        <div class="side-menu__block-overlay custom-cursor__overlay">
            <div class="cursor"></div>
            <div class="cursor-follower"></div>
        </div><!-- /.side-menu__block-overlay -->
        <div class="side-menu__block-inner ">
            <div class="side-menu__top justify-content-end">

                <a href="#" class="side-menu__toggler side-menu__close-btn"><img src="/frontend/linoor/assets/img/icons/close-1-1.png"
                                                                                 alt=""></a>
            </div><!-- /.side-menu__top -->


            <nav class="mobile-nav__container">
                <!-- content is loading via js -->
            </nav>
            <div class="side-menu__sep"></div><!-- /.side-menu__sep -->
            <div class="side-menu__content">
                <p>Linoor is a premium Template for Digital Agencies, Start Ups, Small Business and a wide range of
                    other agencies.</p>
                <p><a href="mailto:needhelp@linoor.com">needhelp@linoor.com</a> <br> <a href="tel:888-999-0000">888
                        999 0000</a></p>
                <div class="side-menu__social">
                    <a href="#"><i class="fab fa-facebook-square"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div><!-- /.side-menu__content -->
        </div><!-- /.side-menu__block-inner -->
    </div>
    <!--Search Popup-->
    <div class="search-popup">
        <div class="search-popup__overlay custom-cursor__overlay">
            <div class="cursor"></div>
            <div class="cursor-follower"></div>
        </div><!-- /.search-popup__overlay -->
        <div class="search-popup__inner">
            <form action="#" class="search-popup__form">
                <input type="text" name="search" placeholder="Type here to Search....">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div><!-- /.search-popup__inner -->
    </div>
    @yield('content')
    <a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <footer class="main-footer">
        <div class="auto-container">
            <!--Widgets Section-->
            <div class="widgets-section">
                <div class="row clearfix">

                    <!--Column-->
                    <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-widget logo-widget">
                            <div class="widget-content">
                                <div class="logo">
                                    <a href="index.html"><img id="fLogo" src="/frontend/linoor/assets/img/footer-logo.png" alt=""/></a>
                                </div>
                                <div class="text">Welcome to our web design agency. Lorem ipsum simply free text
                                    dolor sited amet cons cing elit.
                                </div>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-widget links-widget">
                            <div class="widget-content">
                                <h6>Explore</h6>
                                <div class="row clearfix">
                                    <div class="col-md-6 col-sm-12">
                                        <ul>
                                            <li><a href="#">About</a></li>
                                            <li><a href="#">Meet Our Team</a></li>
                                            <li><a href="#">Our Portfolio</a></li>
                                            <li><a href="#">Latest News</a></li>
                                            <li><a href="#">Contact</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <ul>
                                            <li><a href="#">Support</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                            <li><a href="#">Terms of Use</a></li>
                                            <li><a href="#">Help</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-widget info-widget">
                            <div class="widget-content">
                                <h6>Contact</h6>
                                <ul class="contact-info">
                                    <li class="address"><span class="icon flaticon-pin-1"></span> 66 Broklyn Street,
                                        New York <br>United States of America
                                    </li>
                                    <li><span class="icon flaticon-call"></span><a href="tel:666888000">666 888
                                            000</a></li>
                                    <li><span class="icon flaticon-email-2"></span><a
                                                href="mailto:needhelp@linoor.com">needhelp@linoor.com</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-widget newsletter-widget">
                            <div class="widget-content">
                                <h6>Newsletter</h6>
                                <div class="newsletter-form">
                                    <form method="post" action="contact.html">
                                        <div class="form-group clearfix">
                                            <input type="email" name="email" value="" placeholder="Email Address"
                                                   required="">
                                            <button type="submit" class="theme-btn"><span
                                                        class="fa fa-envelope"></span></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="text">Sign up for our latest news & articles. We won’t give you spam
                                    mails.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="auto-container">
                <div class="inner clearfix">
                    <div class="copyright">&copy; Copyright 2022 by Layerdrops.com</div>
                </div>
            </div>
        </div>

    </footer>
</div>
<?= MainAsset::js() ?>
</body>
</html>
