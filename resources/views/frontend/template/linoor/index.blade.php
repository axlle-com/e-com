<?php

use App\Common\Assets\MainAsset;
use App\Common\Models\Setting\Setting;

$template = Setting::template();

/**
 * @var $title string
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
                    <div class="image-layer" style="background-image: url(images/main-slider/1.jpg);"></div>
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
                    <div class="image-layer" style="background-image: url(images/main-slider/2.jpg);"></div>
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
        <!--Services Section-->
        <section class="services-section">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Title Block-->
                    <div class="title-block col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2>We Shape the Perfect <br>Solutions<span class="dot">.</span></h2>
                                <div class="lower-text">We are committed to providing our customers with exceptional
                                    service while offering our employees the best training.</div>
                            </div>
                        </div>
                    </div>
                    <!--Service Block-->
                    <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft" data-wow-delay="0ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="bottom-curve"></div>
                            <div class="icon-box"><span class="flaticon-responsive"></span></div>
                            <h6><a href="web-development.html">Website <br>Development</a></h6>
                        </div>
                    </div>
                    <!--Service Block-->
                    <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft"
                         data-wow-delay="300ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="bottom-curve"></div>
                            <div class="icon-box"><span class="flaticon-computer"></span></div>
                            <h6><a href="graphic-designing.html">graphic <br>designing</a></h6>
                        </div>
                    </div>
                    <!--Service Block-->
                    <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft" data-wow-delay="0ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="bottom-curve"></div>
                            <div class="icon-box"><span class="flaticon-digital-marketing"></span></div>
                            <h6><a href="digital-marketing.html">digital <br>marketing</a></h6>
                        </div>
                    </div>
                    <!--Service Block-->
                    <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft"
                         data-wow-delay="300ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="bottom-curve"></div>
                            <div class="icon-box"><span class="flaticon-development"></span></div>
                            <h6><a href="seo.html">seo & content <br>writing</a></h6>
                        </div>
                    </div>
                    <!--Service Block-->
                    <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft"
                         data-wow-delay="600ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="bottom-curve"></div>
                            <div class="icon-box"><span class="flaticon-app-development"></span></div>
                            <h6><a href="app-development.html">App <br>Development</a></h6>
                        </div>
                    </div>
                    <!--Service Block-->
                    <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft"
                         data-wow-delay="900ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="bottom-curve"></div>
                            <div class="icon-box"><span class="flaticon-ui"></span></div>
                            <h6><a href="ui-designing.html">Ui/UX <br>designing</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--About Section-->
        <section class="about-section about-section__dark">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Image Column-->
                    <div class="image-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="image-block wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms"><img
                                        src="images/resource/featured-image-1.jpg" alt=""></div>
                            <div class="image-block wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms"><img
                                        src="images/resource/featured-image-2.jpg" alt=""></div>
                        </div>
                    </div>
                    <!--Text Column-->
                    <div class="text-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2>We’re the best agency <br>in downtown<span class="dot">.</span></h2>
                                <div class="lower-text">We are committed to providing our customers with exceptional
                                    service while offering our employees the best training.</div>
                            </div>
                            <div class="text">
                                <p>Lorem Ipsum is simply dummy text of free available in market the printing and
                                    typesetting industry has been the industry's standard dummy text ever.</p>
                            </div>
                            <div class="text clearfix">
                                <ul>
                                    <li>Suspe ndisse suscipit sagittis leo.</li>
                                    <li>Entum estibulum dignissim posuere.</li>
                                    <li>If you are going to use a passage.</li>
                                </ul>
                                <div class="since"><span class="txt">Since <br>2008</span></div>
                            </div>
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
        </section>
        <!--Live Section-->
        <section class="live-section live-section__dark">
            <div class="auto-container">
                <div class="sec-title centered">
                    <h2>Experience us live<span class="dot">.</span></h2>
                </div>
                <div class="main-image-box">
                    <div class="image-layer" style="background-image: url(images/resource/featured-image-3.jpg);"></div>
                    <div class="inner clearfix">
                        <div class="round-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="round-inner">
                                <div class="vid-link">
                                    <a href="https://www.youtube.com/watch?v=Get7rqXYrbQ" class="lightbox-image">
                                        <div class="icon"><span class="flaticon-play-button-1"></span><i
                                                    class="ripple"></i></div>
                                    </a>
                                </div>
                                <div class="title">
                                    <h3>agency that gets <br>excited about</h3>
                                </div>
                                <div class="more-link"><a href="about.html">Read More</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--We DO Section-->
        <section class="we-do-section we-do-section__dark">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Left Column-->
                    <div class="left-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2>We do more then ever <br>platforms<span class="dot">.</span></h2>
                            </div>
                            <div class="featured-block clearfix">
                                <div class="image"><img src="images/resource/featured-image-4.jpg" alt=""></div>
                                <div class="text">There are many variatns of passages the majority have suffered
                                    alteration in some foor randomised words believable.</div>
                            </div>
                            <div class="progress-box">
                                <div class="bar-title">Digital marketing</div>
                                <div class="bar">
                                    <div class="bar-inner count-bar" data-percent="70%">
                                        <div class="count-box">
                                            <span class="count-text" data-stop="70" data-speed="1500">0</span>%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Right Column-->
                    <div class="right-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="faq-box">
                                <ul class="accordion-box accordion-box__dark clearfix">
                                    <!--Block-->
                                    <li class="accordion block active-block">
                                        <div class="acc-btn active"><span class="count">1.</span> We help to create
                                            visual strategies</div>
                                        <div class="acc-content current">
                                            <div class="content">
                                                <div class="text">There are many variations of passages the majority
                                                    have suffered alteration in some fo injected humour, or randomised
                                                    words believable.</div>
                                            </div>
                                        </div>
                                    </li>

                                    <!--Block-->
                                    <li class="accordion block">
                                        <div class="acc-btn"><span class="count">2.</span> Motion Graphics & Animations
                                        </div>
                                        <div class="acc-content">
                                            <div class="content">
                                                <div class="text">There are many variations of passages the majority
                                                    have suffered alteration in some fo injected humour, or randomised
                                                    words believable.</div>
                                            </div>
                                        </div>
                                    </li>

                                    <!--Block-->
                                    <li class="accordion block">
                                        <div class="acc-btn"><span class="count">3.</span> We help to achieve mutual
                                            goals</div>
                                        <div class="acc-content">
                                            <div class="content">
                                                <div class="text">There are many variations of passages the majority
                                                    have suffered alteration in some fo injected humour, or randomised
                                                    words believable.</div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Gallery Section -->
        <section class="gallery-section gallery-section__dark">
            <div class="auto-container">
                <!--MixitUp Galery-->
                <div class="mixitup-gallery">
                    <div class="upper-row clearfix">
                        <div class="sec-title">
                            <h2>work showcase<span class="dot">.</span></h2>
                        </div>
                        <!--Filter-->
                        <div class="filters clearfix">
                            <ul class="filter-tabs filter-btns clearfix">
                                <li class="active filter" data-role="button" data-filter="all">All<sup>[6]</sup></li>
                                <li class="filter" data-role="button" data-filter=".branding">Branding<sup>[3]</sup>
                                </li>
                                <li class="filter" data-role="button" data-filter=".illustration">
                                    illustration<sup>[3]</sup></li>
                                <li class="filter" data-role="button" data-filter=".photography">
                                    Photography<sup>[3]</sup></li>
                                <li class="filter" data-role="button" data-filter=".web-design">Web Design<sup>[4]</sup>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-list row">
                        <!-- Gallery Item -->
                        <div class="gallery-item mix all web-design col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <figure class="image"><img src="images/gallery/1.jpg" alt=""></figure>
                                <a href="images/gallery/1.jpg" class="lightbox-image overlay-box"
                                   data-fancybox="gallery"></a>
                                <div class="cap-box">
                                    <div class="cap-inner">
                                        <div class="cat"><span>Graphic</span></div>
                                        <div class="title">
                                            <h5><a href="portfolio-single.html">Fimlor Experience</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Item -->
                        <div class="gallery-item mix all photography web-design col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <figure class="image"><img src="images/gallery/2.jpg" alt=""></figure>
                                <a href="images/gallery/2.jpg" class="lightbox-image overlay-box"
                                   data-fancybox="gallery"></a>
                                <div class="cap-box">
                                    <div class="cap-inner">
                                        <div class="cat"><span>Graphic</span></div>
                                        <div class="title">
                                            <h5><a href="portfolio-single.html">Fimlor Experience</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Item -->
                        <div class="gallery-item mix all branding web-design col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <figure class="image"><img src="images/gallery/3.jpg" alt=""></figure>
                                <a href="images/gallery/3.jpg" class="lightbox-image overlay-box"
                                   data-fancybox="gallery"></a>
                                <div class="cap-box">
                                    <div class="cap-inner">
                                        <div class="cat"><span>Graphic</span></div>
                                        <div class="title">
                                            <h5><a href="portfolio-single.html">Fimlor Experience</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Item -->
                        <div class="gallery-item mix all branding illustration col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <figure class="image"><img src="images/gallery/4.jpg" alt=""></figure>
                                <a href="images/gallery/4.jpg" class="lightbox-image overlay-box"
                                   data-fancybox="gallery"></a>
                                <div class="cap-box">
                                    <div class="cap-inner">
                                        <div class="cat"><span>Graphic</span></div>
                                        <div class="title">
                                            <h5><a href="portfolio-single.html">Fimlor Experience</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Item -->
                        <div
                                class="gallery-item mix all branding illustration photography web-design col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <figure class="image"><img src="images/gallery/5.jpg" alt=""></figure>
                                <a href="images/gallery/5.jpg" class="lightbox-image overlay-box"
                                   data-fancybox="gallery"></a>
                                <div class="cap-box">
                                    <div class="cap-inner">
                                        <div class="cat"><span>Graphic</span></div>
                                        <div class="title">
                                            <h5><a href="portfolio-single.html">Fimlor Experience</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Item -->
                        <div class="gallery-item mix all illustration photography col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <figure class="image"><img src="images/gallery/6.jpg" alt=""></figure>
                                <a href="images/gallery/6.jpg" class="lightbox-image overlay-box"
                                   data-fancybox="gallery"></a>
                                <div class="cap-box">
                                    <div class="cap-inner">
                                        <div class="cat"><span>Graphic</span></div>
                                        <div class="title">
                                            <h5><a href="portfolio-single.html">Fimlor Experience</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>
        <!-- Funfacts Section -->
        <section class="facts-section jarallax" data-jarallax data-speed="0.3" data-imgPosition="50% 80%">
            <!-- <div class="image-layer" style="background-image: url(images/background/image-1.jpg);"></div> -->
            <img src="images/background/image-1.jpg" alt="" class="jarallax-img">
            <div class="auto-container">
                <div class="inner-container">

                    <!-- Fact Counter -->
                    <div class="fact-counter">
                        <div class="row clearfix">

                            <!--Column-->
                            <div class="column counter-column col-lg-3 col-md-6 col-sm-12">
                                <div class="inner">
                                    <div class="content">
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="4000" data-stop="8705">0</span>
                                        </div>
                                        <div class="counter-title">Projects Completed</div>
                                    </div>
                                </div>
                            </div>

                            <!--Column-->
                            <div class="column counter-column col-lg-3 col-md-6 col-sm-12">
                                <div class="inner">
                                    <div class="content">
                                        <div class="count-outer count-box alternate">
                                            <span class="count-text" data-speed="3000" data-stop="480">0</span>
                                        </div>
                                        <div class="counter-title">Active clients</div>
                                    </div>
                                </div>
                            </div>

                            <!--Column-->
                            <div class="column counter-column col-lg-3 col-md-6 col-sm-12">
                                <div class="inner">
                                    <div class="content">
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="3000" data-stop="626">0</span>
                                        </div>
                                        <div class="counter-title">cups of coffee</div>
                                    </div>
                                </div>
                            </div>

                            <!--Column-->
                            <div class="column counter-column col-lg-3 col-md-6 col-sm-12">
                                <div class="inner">
                                    <div class="content">
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="4000" data-stop="9704">0</span>
                                        </div>
                                        <div class="counter-title">happy clients</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- End Funfacts Section -->
        <!-- Trusted Section -->
        <section class="trusted-section trusted-section__dark">
            <div class="auto-container">
                <div class="outer-container">
                    <div class="row clearfix">
                        <div class="left-col col-xl-5 col-lg-6 col-md-12 col-sm-12">
                            <div class="inner">
                                <div class="col-header">
                                    <div class="header-inner">
                                        <span>We’re Committed To Deliver High Quality Projects .</span>
                                    </div>
                                </div>
                                <div class="features">
                                    <div class="feature">
                                        <div class="count"><span>01</span></div>
                                        <h5>TOTAL DESIGN FREEDOM FOR EVERYONE</h5>
                                        <div class="sub-text">core features</div>
                                    </div>
                                    <div class="feature">
                                        <div class="count"><span>02</span></div>
                                        <h5>BASIC RULES OF RUNNING WEB AGENCY</h5>
                                        <div class="sub-text">core features</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right-col col-xl-7 col-lg-6 col-md-12 col-sm-12">
                            <div class="inner">
                                <div class="sec-title">
                                    <h2>We’re trusted by more <br>than 6260 clients<span class="dot">.</span></h2>
                                    <div class="lower-text">There are many variations of passages of Lorem Ipsum
                                        available, but the majority have suffered alteration in some form, simply free
                                        text by injected humour, or randomised.</div>
                                </div>
                                <div class="featured-block-two clearfix">
                                    <div class="image"><img src="images/resource/featured-image-5.jpg" alt=""></div>
                                    <div class="text">
                                        <ul>
                                            <li> Suspe ndisse sagittis leo.</li>
                                            <li>Entum estibulum is posuere.</li>
                                            <li>If you are going to use passage.</li>
                                            <li>Lorem Ipsum on the tend to repeat.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- Team Section -->
        <section class="team-section no-padd-top team-section__dark">
            <div class="auto-container">
                <div class="sec-title centered">
                    <h2>Meet the expert team<span class="dot">.</span></h2>
                </div>
            </div>
            <div class="carousel-box">
                <div class="team-carousel owl-theme owl-carousel">
                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-1.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Kevin martin</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-2.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Jessica Brown</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-3.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">John Albert</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-4.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Rose ford</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-5.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Mike Hardson</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>
                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-1.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Kevin martin</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-2.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Jessica Brown</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-3.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">John Albert</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-4.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Rose ford</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-5.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Mike Hardson</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-1.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Kevin martin</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-2.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Jessica Brown</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-3.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">John Albert</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-4.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Rose ford</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                    <!--Team-->
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="about.html"><img src="images/resource/team-5.jpg" alt=""></a>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                            <div class="lower-box">
                                <h5><a href="#">Mike Hardson</a></h5>
                                <div class="designation">Designer</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- Parallax Section -->
        <section class="parallax-section jarallax" data-jarallax data-speed="0.3" data-imgPosition="50% 80%">
            <!-- <div class="image-layer" style="background-image: url(images/background/image-2.jpg);"></div> -->
            <img src="images/background/image-2.jpg" alt="" class="jarallax-img">
            <div class="auto-container">
                <div class="content-box">
                    <div class="icon-box"><span class="flaticon-app-development"></span></div>
                    <h2>Great things in business are never done by one person. <span>They’re done by a team of
                            people.</span></h2>
                </div>
            </div>
        </section>
        <!-- End Funfacts Section -->
        <!--Sponsors Section-->
        <section class="sponsors-section sponsors-section__dark">
            <div class="sponsors-outer">
                <!--Sponsors-->
                <div class="auto-container">
                    <!--Sponsors Carousel-->
                    <div class="sponsors-carousel owl-theme owl-carousel">
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                        <div class="slide-item">
                            <figure class="image-box"><a href="#"><img src="images/clients/dark-1.png" alt=""></a>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Agency Section-->
        <section class="agency-section agency-section__dark">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Left Column-->
                    <div class="left-col col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2>Best design Agency <br>solutions<span class="dot">.</span></h2>
                            </div>

                            <!--Default Tabs-->
                            <div class="default-tabs tabs-box">

                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    <li data-tab="#tab-1" class="tab-btn active-btn"><span>Our Mission</span></li>
                                    <li data-tab="#tab-2" class="tab-btn"><span>Our Vision</span></li>
                                    <li data-tab="#tab-3" class="tab-btn"><span>Our History</span></li>
                                </ul>

                                <!--Tabs Container-->
                                <div class="tabs-content">

                                    <!--Tab-->
                                    <div class="tab active-tab" id="tab-1">
                                        <div class="content">
                                            <div class="text">There are many variations of passages of avaialable but
                                                the majority have in some form, by injected humou or words which don't
                                                look even slightly believable. There are many variations of but the
                                                majority have suffered.</div>
                                        </div>
                                    </div>

                                    <!--Tab-->
                                    <div class="tab" id="tab-2">
                                        <div class="content">
                                            <div class="text">There are many variations of passages of avaialable but
                                                the majority have in some form, by injected humou or words which don't
                                                look even slightly believable. There are many variations of but the
                                                majority have suffered.</div>
                                        </div>
                                    </div>

                                    <!--Tab-->
                                    <div class="tab" id="tab-3">
                                        <div class="content">
                                            <div class="text">There are many variations of passages of avaialable but
                                                the majority have in some form, by injected humou or words which don't
                                                look even slightly believable. There are many variations of but the
                                                majority have suffered.</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Right Column-->
                    <div class="right-col col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="text">There are many variations of passages of available but the majority have
                                suffered alteration in some form, by injected humou or randomised words which don't look
                                even slightly believable.</div>
                            <div class="featured-block-two clearfix">
                                <div class="image"><img src="images/resource/featured-image-6.jpg" alt=""></div>
                                <div class="text">
                                    <ul>
                                        <li>Nsectetur cing elit.</li>
                                        <li>Suspe ndisse suscipit sagittis leo.</li>
                                        <li>Entum estibulum dignissim posuere.</li>
                                        <li>If you are going to use a passage.</li>
                                        <li>Lorem Ipsum on the tend to repeat.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- News Section -->
        <section class="news-section news-section__dark">
            <div class="auto-container">
                <div class="sec-title centered">
                    <h2>Latest news & articles<span class="dot">.</span></h2>
                </div>

                <div class="row clearfix">
                    <!--News Block-->
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="blog-single.html"><img src="images/resource/news-1.jpg" alt=""></a>
                            </div>
                            <div class="lower-box">
                                <div class="post-meta">
                                    <ul class="clearfix">
                                        <li><span class="far fa-clock"></span> 20 Mar</li>
                                        <li><span class="far fa-user-circle"></span> Admin</li>
                                        <li><span class="far fa-comments"></span> 2 Comments</li>
                                    </ul>
                                </div>
                                <h5><a href="blog-single.html">basic rules of running web agency business</a></h5>
                                <div class="text">Lorem ipsum is simply free text used by copytyping refreshing.</div>
                                <div class="link-box"><a class="theme-btn" href="blog-single.html"><span
                                                class="flaticon-next-1"></span></a></div>
                            </div>
                        </div>
                    </div>
                    <!--News Block-->
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="300ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="blog-single.html"><img src="images/resource/news-2.jpg" alt=""></a>
                            </div>
                            <div class="lower-box">
                                <div class="post-meta">
                                    <ul class="clearfix">
                                        <li><span class="far fa-clock"></span> 20 Mar</li>
                                        <li><span class="far fa-user-circle"></span> Admin</li>
                                        <li><span class="far fa-comments"></span> 2 Comments</li>
                                    </ul>
                                </div>
                                <h5><a href="blog-single.html">Delivering the best digital marketing</a></h5>
                                <div class="text">Lorem ipsum is simply free text used by copytyping refreshing.</div>
                                <div class="link-box"><a class="theme-btn" href="blog-single.html"><span
                                                class="flaticon-next-1"></span></a></div>
                            </div>
                        </div>
                    </div>
                    <!--News Block-->
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="600ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="image-box">
                                <a href="blog-single.html"><img src="images/resource/news-3.jpg" alt=""></a>
                            </div>
                            <div class="lower-box">
                                <div class="post-meta">
                                    <ul class="clearfix">
                                        <li><span class="far fa-clock"></span> 20 Mar</li>
                                        <li><span class="far fa-user-circle"></span> Admin</li>
                                        <li><span class="far fa-comments"></span> 2 Comments</li>
                                    </ul>
                                </div>
                                <h5><a href="blog-single.html">Introducing the latest linoor features</a></h5>
                                <div class="text">Lorem ipsum is simply free text used by copytyping refreshing.</div>
                                <div class="link-box"><a class="theme-btn" href="blog-single.html"><span
                                                class="flaticon-next-1"></span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Call To Section -->
        <section class="call-to-section">
            <div class="auto-container">
                <div class="inner clearfix">
                    <div class="shape-1 wow slideInRight" data-wow-delay="0ms" data-wow-duration="1500ms"></div>
                    <div class="shape-2 wow fadeInDown" data-wow-delay="0ms" data-wow-duration="1500ms"></div>
                    <h2>Let's Get Your Project <br>Started!</h2>
                    <div class="link-box">
                        <a class="theme-btn btn-style-two" href="about.html">
                            <i class="btn-curve"></i>
                            <span class="btn-title">Contact with us</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main Footer -->
@endsection
