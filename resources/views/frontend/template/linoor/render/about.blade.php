<?php

use App\Common\Assets\MainAsset;
use App\Common\Models\Setting\Setting;

/**
 * @var $title string
 * @var $template string
 */

?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <div id="about" class="tokyo_tm_section active animated fadeInLeft">
        <div class="container">
            <div class="tokyo_tm_about">
                <div class="tokyo_tm_title">
                    <div class="title_flex">
                        <div class="left">
                            <span>обо мне</span>
                            <h3>Обо мне</h3>
                        </div>
                    </div>
                </div>
                <div class="top_author_image">
                    <img src="<?= MainAsset::img('/slider/1.jpg') ?>" alt=""/>
                </div>
                <div class="about_title">
                    <h3>Яков Соколов</h3>
                    <span>Адвокат</span>
                </div>
                <div class="about_text">
                    <p>
                        Более 15 лет опыта профессиональной, преподавательской и общественной деятельности позволяют мне
                        эффективно защищать граждан и бизнес от уголовно-правовых рисков, минимизировать их негативные
                        последствия.
                    </p>
                    <p>
                        Осуществляю защиту по уголовным делам коррупционной направленности, должностным преступлениям и
                        преступлениям, связанным с коммерческой деятельностью.
                    </p>
                    <p>
                        Провожу научные исследования по темам, связанным с проблемами:
                        квалификации и предупреждения коррупционных правонарушений;
                        применения уголовно-процессуального законодательства на следствии и в суде.
                    </p>
                </div>
            </div>
        </div>
        <div class="tokyo_tm_resumebox">
            <div class="container">
                <div class="in">
                    <div class="left">
                        <div class="tokyo_section_title">
                            <h3>Профессиональная деятельность</h3>
                        </div>
                        <div class="tokyo_tm_resume_list">
                            <ul>
                                <li>
                                    <div class="list_inner">
                                        <div class="time">
                                            <span>2006 - 2007</span>
                                        </div>
                                        <div class="place">
                                            <span>Помощник следователя прокуратуры</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list_inner">
                                        <div class="time">
                                            <span>2007 - 2011</span>
                                        </div>
                                        <div class="place">
                                            <span>Следователь, старший следователь Следственного комитета при прокуратуре Российской федерации</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list_inner">
                                        <div class="time">
                                            <span>2011 - 2014</span>
                                        </div>
                                        <div class="place">
                                            <span>Юрисконсульт</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list_inner">
                                        <div class="time">
                                            <span>2014 - н.в.</span>
                                        </div>
                                        <div class="place">
                                            <span>Адвокат</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="right">
                        <div class="tokyo_section_title">
                            <span>Общественная и преподавательская деятельность</span>
                        </div>
                        <div class="tokyo_tm_resume_list">
                            <ul>
                                <li>
                                    <div class="list_inner">
                                        <div class="time">
                                            <span>2015 - 2021</span>
                                        </div>
                                        <div class="place">
                                            <span>Заместитель председателя Региональной общественной организации «Совет молодых юристов Санкт-Петербурга»</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list_inner">
                                        <div class="time">
                                            <span>2016 - 2018</span>
                                        </div>
                                        <div class="place">
                                            <span>Педагог дополнительного образования ГБОУ «Академическая гимназия № 56» Санкт-Петербурга</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list_inner">
                                        <div class="time">
                                            <span>2017 - 2018</span>
                                        </div>
                                        <div class="place">
                                            <span>Преподаватель дисциплины «Уголовный процесс» на кафедре правоведения юридического факультета Северо-западного института управления Российской академии народного хозяйства и государственной службы при Президенте Российской Федерации</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list_inner">
                                        <div class="time">
                                            <span>2022 - н.в.</span>
                                        </div>
                                        <div class="place">
                                            <span>Член экспертно-консультативного совета Комитета Совета Федерации по конституционному законодательству и государственному строительству</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (0){ ?>
        <div class="tokyo_tm_testimonials">
            <div class="container">
                <div class="tokyo_section_title">
                    <h3>Testimonials</h3>
                </div>
                <div class="list">
                    <ul class="owl-carousel">
                        <li>
                            <div class="list_inner">
                                <div class="text">
                                    <p>Beautiful minimalist design and great, fast response with support. Highly
                                        recommend. Thanks Marketify!</p>
                                </div>
                                <div class="details">
                                    <div class="image">
                                        <div class="main" data-img-url="img/testimonials/1.jpg"></div>
                                    </div>
                                    <div class="info">
                                        <h3>Alexander Walker</h3>
                                        <span>Graphic Designer</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="list_inner">
                                <div class="text">
                                    <p>These people really know what they are doing! Great customer support
                                        availability and supperb kindness.</p>
                                </div>
                                <div class="details">
                                    <div class="image">
                                        <div class="main" data-img-url="img/testimonials/2.jpg"></div>
                                    </div>
                                    <div class="info">
                                        <h3>Isabelle Smith</h3>
                                        <span>Content Manager</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="list_inner">
                                <div class="text">
                                    <p>I had a little problem and the support was just awesome to quickly solve
                                        the situation. And keep going on.</p>
                                </div>
                                <div class="details">
                                    <div class="image">
                                        <div class="main" data-img-url="img/testimonials/3.jpg"></div>
                                    </div>
                                    <div class="info">
                                        <h3>Baraka Clinton</h3>
                                        <span>English Teacher</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
@endsection