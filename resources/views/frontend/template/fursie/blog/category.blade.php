<?php

use App\Common\Models\Main\Setting;
use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;

$template = Setting::template();

/**
 * @var $title string
 * @var $models Post[]
 * @var $category PostCategory
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <main class="blog unselectable">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 content">
                    <div class="row">
                        <div class="blog__post col-md-6">
                            <figure class="main icon-overlay">
                                <a href="blog_article.html">
                                    <img src="/frontend/assets/img/gb1.jpg" alt="">
                                </a>
                            </figure>

                            <div class="blog__post-content">
                                <h2 class="blog__post-title">
                                    <a href="blog_article.html" class="">
                                        Adipiscing Mollis Inceptos
                                    </a>
                                </h2>

                                <div class="blog__post-meta">
                                    <span class="date">13 Nov, 2012</span>

                                    <span class="categories">
                                        <a href="#">Breakfast</a>,

                                        <a href="#">Journal</a>
                                    </span>

                                    <span class="comments">
                                        <a href="#">3 Comments</a>
                                    </span>
                                </div>

                                <p class="blog__post-text">
                                    Aenean leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed
                                    posuere
                                    consectetur est at lobortis. Curabitur blandit tempus porttitor. Vivamus sagittis
                                    lacus
                                    vel augue laoreet rutrum faucibus dolor auctor.
                                </p>

                                <a href="#" class="blog__post-more">Continue reading →</a></div>
                        </div>

                        <div class="blog__post col-md-6">
                            <figure class="main icon-overlay">
                                <a href="blog_article.html">
                                    <img src="/frontend/assets/img/gb2.jpg" alt="">
                                </a>
                            </figure>

                            <div class="blog__post-content">
                                <h2 class="blog__post-title">
                                    <a href="blog_article.html">
                                        Ridiculus Ultricies Pellentesque
                                    </a>
                                </h2>

                                <div class="blog__post-meta">
                                    <span class="date">02 Jan, 2013</span>

                                    <span class="categories">
                                        <a href="#">Restaurant</a>,
                                        <a href="#">Photography</a>
                                    </span>

                                    <span class="comments">
                                        <a href="#">5 Comments</a>
                                    </span>
                                </div>

                                <p class="blog__post-text">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget
                                    risus
                                    varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo. Etiam
                                    porta
                                    sem malesuada magna mollis euismod.
                                </p>

                                <a href="#" class="blog__post-more">Continue reading →</a>
                            </div>
                        </div>

                        <div class="blog__post col-md-6">
                            <figure class="main icon-overlay">
                                <a href="blog_article.html">
                                    <img src="/frontend/assets/img/gb3.jpg" alt="">
                                </a>
                            </figure>
                            <div class="blog__post-content">

                                <h2 class="blog__post-title">
                                    <a href="blog_article.html">
                                        Tristique Purus Pharetra
                                    </a>
                                </h2>

                                <div class="blog__post-meta">
                                    <span class="date">14 Mar, 2013</span>
                                    <span class="categories">
                                        <a href="#">Flowers</a>,

                                        <a href="#">Journal</a>
                                    </span>

                                    <span class="comments">
                                        <a href="#">2 Comments</a>
                                    </span>
                                </div>

                                <p class="blog__post-text">
                                    Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Etiam porta sem
                                    malesuada
                                    magna mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean
                                    lacinia
                                    bibendum nulla sed consectetur.
                                </p>

                                <a href="#" class="blog__post-more">Continue reading →</a></div>
                        </div>

                        <div class="blog__post col-md-6">
                            <figure class="main icon-overlay">
                                <a href="blog_article.html">
                                    <img src="/frontend/assets/img/gb4.jpg" alt="">
                                </a>
                            </figure>

                            <div class="blog__post-content">
                                <h2 class="blog__post-title">
                                    <a href="blog_article.html">
                                        Inceptos Porta Nibh
                                    </a>
                                </h2>

                                <div class="blog__post-meta">
                                    <span class="date">23 Apr, 2013 / </span>

                                    <span class="categories">
                                        <a href="#">Street</a>,

                                        <a href="#">Photography</a>
                                    </span>

                                    <span class="comments">
                                        <a href="#">7 Comments</a>
                                    </span>
                                </div>

                                <p class="blog__post-text">
                                    Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Curabitur
                                    blandit
                                    tempus porttitor. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Nulla
                                    vitae elit libero, a pharetra augue.
                                </p>

                                <a href="#" class="blog__post-more">Continue reading →</a></div>
                        </div>
                    </div>
                    <!-- /.blog-posts -->

                    <div class="pagination">
                        <ul>
                            <li><a href="#" class="pagination__btn">Prev</a></li>
                            <li class="active"><a href="#" class="pagination__btn">1</a></li>
                            <li><a href="#" class="pagination__btn">2</a></li>
                            <li><a href="#" class="pagination__btn">3</a></li>
                            <li><a href="#" class="pagination__btn">Next</a></li>
                        </ul>
                    </div>
                    <!-- /.pagination -->

                </div>

                <aside class="col-sm-4 sidebar lp30 sidebar__right">
                    Правый сайдбар с какой-то полезной информацией или подборкой с похожими товарами. Описание продукции
                </aside>
            </div>
        </div>
    </main>
@endsection
