<?php

/**
 * @var $title string
 * @var $template string
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <div id="home" class="tokyo_tm_section active animated fadeInLeft">
        <div class="container">
            <div class="tokyo_tm_home">
                <div class="home_content">
                    <div class="avatar" data-type="wave">
                        <div class="image" data-img-url="<?= _frontend_img('/portfolio/1.jpg') ?>"></div>
                    </div>
                    <div class="details">
                        <h3 class="name">ЯКОВ <span>СОКОЛОВ</span></h3>
                        <p class="job">Адвокат по уголовным делам</p>
                        <p class="job">Защищаю граждан и бизнес</p>
                        <div class="social">
                            <ul>
                                <li><a href="#"><i class="icon-facebook-squared"></i></a></li>
                                <li><a href="#"><i class="icon-twitter-squared"></i></a></li>
                                <li><a href="#"><i class="icon-behance-squared"></i></a></li>
                                <li><a href="#"><i class="icon-linkedin-squared"></i></a></li>
                                <li><a href="#"><i class="icon-instagram-"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
