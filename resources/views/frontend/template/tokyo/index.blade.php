<?php

use App\Common\Models\Setting\Setting;

$template = Setting::template();

/**
 * @var $title string
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
                        <p class="job">Адвокат по уголовным делам<br>Защищаю граждан и бизнес</p>
                        <p class="job-info">
                            Реестровый номер: 77/16399<br>
                            в Адвокатской палате города Москвы
                        </p>
                        <div class="social">
                            <ul>
                                <li><a href="#"><i class="icon-telegram"></i></a></li>
                                <svg width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
                                    <g transform="matrix(0.44 0 0 0.44 12 12)" >
                                        <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-25, -25)" d="M 46.894 23.986 C 46.897999999999996 23.986 46.900999999999996 23.986 46.905 23.986 C 47.184000000000005 23.986 47.45 23.869 47.639 23.664 C 47.831 23.456000000000003 47.926 23.177000000000003 47.901 22.895000000000003 C 46.897 11.852 38.154 3.106 27.11 2.1 C 26.83 2.0780000000000003 26.548 2.169 26.34 2.362 C 26.132 2.5540000000000003 26.016 2.825 26.019 3.108 C 26.193 17.784 28.129 23.781 46.894 23.986 z M 46.894 26.014 C 28.128999999999998 26.218999999999998 26.194 32.216 26.02 46.891999999999996 C 26.017 47.175 26.133 47.446 26.341 47.638 C 26.527 47.809 26.77 47.903999999999996 27.02 47.903999999999996 C 27.05 47.903999999999996 27.081 47.903 27.111 47.9 C 38.155 46.894 46.897999999999996 38.149 47.900999999999996 27.104999999999997 C 47.925999999999995 26.822999999999997 47.831999999999994 26.543999999999997 47.638999999999996 26.336 C 47.446 26.128 47.177 26.025 46.894 26.014 z M 22.823 2.105 C 11.814 3.14 3.099 11.884 2.1 22.897 C 2.075 23.179 2.169 23.458 2.362 23.665999999999997 C 2.551 23.870999999999995 2.818 23.987 3.096 23.987 C 3.1 23.987 3.104 23.987 3.108 23.987 C 21.811 23.772 23.742 17.778 23.918 3.1119999999999983 C 23.921 2.8289999999999984 23.804 2.556999999999998 23.596 2.3649999999999984 C 23.386 2.173 23.105 2.079 22.823 2.105 z M 3.107 26.013 C 2.7960000000000003 25.978 2.552 26.126 2.361 26.334000000000003 C 2.169 26.542 2.0740000000000003 26.821 2.099 27.103 C 3.0980000000000003 38.116 11.814 46.86 22.823 47.895 C 22.854 47.898 22.886 47.899 22.917 47.899 C 23.167 47.899 23.409000000000002 47.805 23.595000000000002 47.634 C 23.803 47.442 23.92 47.17 23.917 46.887 C 23.741 32.222 21.811 26.228 3.107 26.013 z" stroke-linecap="round" />
                                    </g>
                                </svg>
                                <li><a href="#"><i class="icon-yandex"></i></a></li>
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
