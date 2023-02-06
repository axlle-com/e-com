<?php

use App\Common\Assets\MainAsset;
use App\Common\Models\Setting\Setting;

$template = Setting::template();

/**
 * @var string $title
 * @var \App\Common\Models\Blog\Post $posts
 * @var \App\Common\Models\Blog\PostCategory $category
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <!-- Banner Section -->
    <section class="banner-section banner-one">

        <div class="left-based-text">
            <div class="base-inner">
                <div class="hours">
                    <ul class="clearfix">
                        <li><span>mon - fri</span></li>
                        <li><span>9am - 7pm</span></li>
                    </ul>
                </div>
                <div class="social-links">
                    <ul class="clearfix">
                        <li><a href="#"><span>Twitter</span></a></li>
                        <li><a href="#"><span>Facebook</span></a></li>
                        <li><a href="#"><span>Youtube</span></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="banner-carousel owl-theme owl-carousel">
            <!-- Slide Item -->
            <div class="slide-item">
                <div class="image-layer"
                     style="background-image: url(/frontend/linoor/assets/img/main-slider/1.jpg);"></div>
                <div class="left-top-line"></div>
                <div class="right-bottom-curve"></div>
                <div class="right-top-curve"></div>
                <div class="auto-container">
                    <div class="content-box">
                        <div class="content">
                            <div class="inner">
                                <div class="sub-title">welcome to Linoor agency</div>
                                <h1>Smart Web <br>Design Agency</h1>
                                <div class="link-box">
                                    <a class="theme-btn btn-style-one" href="about.html">
                                        <i class="btn-curve"></i>
                                        <span class="btn-title">Discover More</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide Item -->
            <div class="slide-item">
                <div class="image-layer"
                     style="background-image: url(/frontend/linoor/assets/img/main-slider/2.jpg);"></div>
                <div class="left-top-line"></div>
                <div class="right-bottom-curve"></div>
                <div class="right-top-curve"></div>
                <div class="auto-container">
                    <div class="content-box">
                        <div class="content">
                            <div class="inner">
                                <div class="sub-title">welcome to Linoor agency</div>
                                <h1>Smart Web <br>Design Agency</h1>
                                <div class="link-box">
                                    <a class="theme-btn btn-style-one" href="about.html">
                                        <i class="btn-curve"></i>
                                        <span class="btn-title">Discover More</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!--End Banner Section -->
    <div class="side-menu__block">


        <div class="side-menu__block-overlay custom-cursor__overlay">
            <div class="cursor"></div>
            <div class="cursor-follower"></div>
        </div><!-- /.side-menu__block-overlay -->
        <div class="side-menu__block-inner ">
            <div class="side-menu__top justify-content-end">

                <a href="#" class="side-menu__toggler side-menu__close-btn"><img
                        src="/frontend/linoor/assets/img/icons/close-1-1.png"
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
    </div><!-- /.side-menu__block -->

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
    </div><!-- /.search-popup -->

    <!-- Banner Section -->
    <section class="page-banner">
        <div class="image-layer"
             style="background-image:url(/frontend/linoor/assets/img/background/image-7.jpg);"></div>
        <div class="shape-1"></div>
        <div class="shape-2"></div>
        <div class="banner-inner">
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <h1>Portfolio</h1>
                    <div class="page-nav">
                        <ul class="bread-crumb clearfix">
                            <li><a href="index-main.html">Home</a></li>
                            <li class="active">Portfolio</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->

    <!-- Gallery Section -->
    <section class="gallery-section gallery-section-four">
        <div class="auto-container">
            <!--MixitUp Galery-->
            <div class="mixitup-gallery">
                <!--Filter-->
                <div class="filters centered clearfix">
                    <ul class="filter-tabs filter-btns clearfix">
                        <li class="active filter" data-role="button" data-js-filter="0">All<sup>[<?= $count ?>]</sup></li>
                        <?php foreach($category ?? [] as $item){ ?>

                        <li class="filter" data-role="button" data-js-filter="<?= $item->id ?>"><?= $item->title ?>
                            <sup>[3]</sup>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="filter-list row js-filter">
                    <?php foreach($posts ?? [] as $post){ ?>
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="<?= $post->getUrl() ?>">
                                    <img src="/frontend/linoor/assets/img/resource/news-1.jpg" alt=""></a>
                            </div>
                            <div class="lower-box">
                                <div class="post-meta">
                                    <ul class="clearfix">
                                        <li><span class="far fa-clock"></span><?= $post->getCreatedAtShot() ?></li>
                                        <li><span class="far fa-user-circle"></span> Admin</li>
                                        <li><span class="far fa-comments"></span> 2 Comments</li>
                                    </ul>
                                </div>
                                <h5><a href="<?= $post->url ?>"><?= $post->title_short ?? $post->title ?></a></h5>
                                <div class="text"></div>
                                <div class="link-box">
                                    <a class="theme-btn" href="<?= $post->url ?>"><span class="flaticon-next-1"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </section>
@endsection
