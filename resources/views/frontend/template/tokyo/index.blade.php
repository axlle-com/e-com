<?php

use App\Common\Models\Main\Setting;

$template = Setting::template();

/**
 * @var $title string
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <div id="home" class="tokyo_tm_section animated">
        <div class="container">
            <div class="tokyo_tm_home">
                <div class="home_content">
                    <div class="avatar" data-type="wave">
                        <!-- data-type values are: "wave", "circle", "square"-->
                        <div class="image" data-img-url="<?= _frontend_img('/portfolio/1.jpg') ?>"></div>
                    </div>
                    <div class="details">
                        <h3 class="name">Adriano <span>Smith</span></h3>
                        <p class="job">I am a WordPress Developer at heart and create features that are best
                            suited for the job at hand.</p>
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
