<?php

use App\Common\Models\Blog\Post;
use App\Common\Models\Setting\Setting;

$template = Setting::template();

/**
 * @var $title string
 * @var $model Post
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
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
    <!-- Banner Section -->
    <section class="page-banner">
        <div class="image-layer" style="background-image:url(/frontend/linoor/assets/img/background/image-7.jpg);"></div>
        <div class="shape-1"></div>
        <div class="shape-2"></div>
        <div class="banner-inner">
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <h1>Blog Posts</h1>
                    <div class="page-nav">
                        <ul class="bread-crumb clearfix">
                            <li><a href="index-main.html">Home</a></li>
                            <li class="active">Blog Single</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->
    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row clearfix">

                <!--Content Side-->
                <div class="content-side col-lg-8 col-md-12 col-sm-12">
                    <div class="blog-details">
                        <!--News Block-->
                        <div class="post-details">
                            <div class="inner-box">
                                <div class="image-box">
                                    <a href="blog-single.html"><img src="/frontend/linoor/assets/img/resource/news-7.jpg" alt=""></a>
                                </div>
                                <div class="lower-box">
                                    <div class="post-meta">
                                        <ul class="clearfix">
                                            <li><span class="far fa-clock"></span> 20 Mar</li>
                                            <li><span class="far fa-user-circle"></span> Admin</li>
                                            <li><span class="far fa-comments"></span> 2 Comments</li>
                                        </ul>
                                    </div>
                                    <h4><?= $model->title ?></h4>
                                    <div class="text"><?= $model->description ?></div>
                                </div>
                            </div>
                            <div class="info-row clearfix">
                                <div class="tags-info"><strong>Tags:</strong> <a href="#">Business</a>, <a
                                            href="#">Agency</a>, <a href="#">Technology</a></div>
                                <div class="cat-info"><strong>Category:</strong> <a href="#">Business</a>, <a
                                            href="#">Agency</a></div>
                            </div>
                        </div>
                        <div class="post-control-two">
                            <div class="row clearfix">
                                <div class="control-col col-md-6 col-sm-12">
                                    <div class="control-inner">
                                        <h4><a href="#">A DEEP UNDERSTANDING OF OUR AUDIENCE</a></h4>
                                        <a href="#" class="over-link"></a>
                                    </div>
                                </div>
                                <div class="control-col col-md-6 col-sm-12">
                                    <div class="control-inner">
                                        <h4><a href="#">EXPERIENCES THAT CONNECT WITH PEOPLE</a></h4>
                                        <a href="#" class="over-link"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Comments Area-->

                        <div class="comments-area comment-block-widget">
                            <div class="comments-title">
                                <h3>2 Comments</h3>
                            </div>
                            <?php if ($model->comments) { ?>
                                <?= $model->getComments(); ?>
                            <?php } ?>
                        </div>

                        <!--Leave Comment Form-->
                        <div class="leave-comments">
                            <div class="comments-title">
                                <h3>Leave a comment</h3>
                            </div>
                            <div class="default-form comment-form">
                                <form method="post" action="/ajax/add-comment">
                                    <input type="hidden" name="resource" value="<?= $model->getTable() ?>">
                                    <input type="hidden" name="resource_id" value="<?= $model->id ?>">
                                    <input type="hidden" name="comment_id" value="">
                                    <div class="row clearfix">
                                        <div class="col-md-6 col-sm-12 form-group">
                                            <input type="text" name="name" placeholder="Your Name" data-validator="name">
                                        </div>

                                        <div class="col-md-6 col-sm-12 form-group">
                                            <input type="email" name="email" placeholder="Email Address" data-validator="email">
                                        </div>
                                        <div class="col-md-12 col-sm-12 form-group">
                                            <textarea name="text" placeholder="Your Comments" data-validator="text"></textarea>
                                        </div>

                                        <div class="col-md-12 col-sm-12 form-group">
                                            <button class="theme-btn btn-style-one js-comment-button">
                                                <i class="btn-curve"></i>
                                                <span class="btn-title">Submit Comment</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Sidebar Side-->
                <div class="sidebar-side col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar blog-sidebar">
                        <!--Sidebar Widget-->
                        <div class="sidebar-widget search-box">
                            <div class="widget-inner">
                                <form method="post" action="blog.html">
                                    <div class="form-group">
                                        <input type="search" name="search-field" value="" placeholder="Search"
                                               required="">
                                        <button type="submit"><span
                                                    class="icon flaticon-magnifying-glass-1"></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="sidebar-widget recent-posts">
                            <div class="widget-inner">
                                <div class="sidebar-title">
                                    <h4>Latest Posts</h4>
                                </div>

                                <div class="post">
                                    <figure class="post-thumb"><img src="/frontend/linoor/assets/img/resource/news-thumb-1.jpg" alt="">
                                    </figure>
                                    <h5 class="text"><a href="#">EXPERIENCES THAT CONNECT WITH PEOPLE</a></h5>
                                </div>

                                <div class="post">
                                    <figure class="post-thumb"><img src="/frontend/linoor/assets/img/resource/news-thumb-2.jpg" alt="">
                                    </figure>
                                    <h5 class="text"><a href="#">WE BUILD AND ACTIVATE BRANDS INSIGHT</a></h5>
                                </div>

                                <div class="post">
                                    <figure class="post-thumb"><img src="/frontend/linoor/assets/img/resource/news-thumb-3.jpg" alt="">
                                    </figure>
                                    <h5 class="text"><a href="#">A DEEP UNDERSTANDING OF OUR AUDIENCE</a></h5>
                                </div>

                            </div>
                        </div>

                        <div class="sidebar-widget archives">
                            <div class="widget-inner">
                                <div class="sidebar-title">
                                    <h4>Categories</h4>
                                </div>
                                <ul>
                                    <li><a href="blog.html">Business</a></li>
                                    <li class="active"><a href="blog.html">Introductions</a></li>
                                    <li><a href="blog.html">One Page Template</a></li>
                                    <li><a href="blog.html">Parallax Effects</a></li>
                                    <li><a href="blog.html">New Technologies</a></li>
                                    <li><a href="blog.html">Video Backgrounds</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="sidebar-widget popular-tags">
                            <div class="widget-inner">
                                <div class="sidebar-title">
                                    <h4>Tags</h4>
                                </div>
                                <div class="tags-list clearfix">
                                    <a href="#">Business</a>, <a href="#">Agency</a>, <a href="#">Technology</a>,<a
                                            href="#">Parallax</a>, <a href="#">Innovative</a>, <a
                                            href="#">Professional</a>,<a href="#">Experience</a>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget recent-comments">
                            <div class="widget-inner">
                                <div class="sidebar-title">
                                    <h4>Comments</h4>
                                </div>

                                <div class="comment">
                                    <div class="icon">
                                        <span class="flaticon-speech-bubble-2"></span>
                                    </div>
                                    <h5 class="text"><a href="#">A Wordpress Commenter on Launch New Mobile App</a>
                                    </h5>
                                </div>

                                <div class="comment">
                                    <div class="icon">
                                        <span class="flaticon-speech-bubble-2"></span>
                                    </div>
                                    <h5 class="text"><a href="#">John Doe on Template: <br>Comments</a></h5>
                                </div>

                                <div class="comment">
                                    <div class="icon">
                                        <span class="flaticon-speech-bubble-2"></span>
                                    </div>
                                    <h5 class="text"><a href="#">A Wordpress Commenter on Launch New Mobile App</a>
                                    </h5>
                                </div>

                                <div class="comment">
                                    <div class="icon">
                                        <span class="flaticon-speech-bubble-2"></span>
                                    </div>
                                    <h5 class="text"><a href="#">John Doe on Template: <br>Comments</a></h5>
                                </div>

                            </div>
                        </div>


                    </aside>
                </div>

            </div>
        </div>
    </div>
@endsection
