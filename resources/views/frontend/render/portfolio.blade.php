<?php

/**
 * @var $title string
 * @var $model Page
 * @var $image GalleryImage
 */

use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Page\Page;

?>
@extends('frontend.layout',['title' => $model->title ?? ''])
@section('content')
    <main class="isotope__container unselectable">
        <div class="light-wrapper">
            <div class="container-fluid">
                <div class="portfolio classic-masonry">
                    <div class="clearfix"></div>
                    <div class="row">
                        <?php if($galleries = $model->manyGalleryWithImages){ ?>
                        <?php foreach ($galleries as $gallery){ ?>
                        <?php foreach ($gallery->images as $image){ ?>
                        <div class="col-4 portfolio-item">
                            <figure>
                                <a
                                    href="<?= $image->url ?>"
                                    class="fancybox-media"
                                    data-fancybox="gallery"
                                    data-title-id="title-01">
                                    <div class="text-overlay">
                                        <div class="info"><span><?= $image->title ?? 'Заголовок'?></span></div>
                                    </div>
                                    <img src="<?= $image->url ?>" alt="<?= $image->title ?? 'Заголовок'?>"></a>
                            </figure>
                            <div id="title-01" class="info hidden">
                                <h2><?= $image->title ?? 'Заголовок'?></h2>
                            </div>
                        </div>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
