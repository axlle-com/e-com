<?php

use App\Common\Models\Blog\PostCategory;

/**
 * @var $title string
 * @var $template string
 * @var $model PostCategory
 */
$posts = $model->posts ?? [];
?>
@extends($template.'layout',['title' => $title ?? ''])
@section('content')
    <div id="service" class="tokyo_tm_section active animated fadeInLeft">
        <div class="container">
            <div class="tokyo_tm_services">
                <div class="tokyo_tm_title">
                    <div class="title_flex">
                        <div class="left">
                            <span><?= $title ?></span>
                            <h3><?= $title ?></h3>

                        </div>
                    </div>
                </div>
                <div class="list">
                    <ul>
                        <?php $cnt = 1 ?>
                        <?php foreach ($posts as $post){ ?>
                        <li>
                            <div class="list_inner">
                                <span class="number"><?= $cnt ?></span>
                                <h3 class="title"><?= $post['title'] ?></h3>
                                <p class="text"><?= $post['preview_description'] ?></p>
                                <div class="tokyo_tm_read_more">
                                    <a href="#"><span>Читать</span></a>
                                </div>
                                <a class="tokyo_tm_full_link" href="#"></a>
                                <!-- Service Popup Start -->
                                <div class="service_hidden_details">
                                    <div class="service_popup_informations">
                                        <div class="descriptions">
                                            <?= $post['description'] ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                            <?php $cnt++ ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
