<?php

use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Page\Page;
use App\Common\Models\Setting\Setting;

$template = Setting::template();

/**
 * @var $title string
 * @var $model Page
 * @var $image GalleryImage
 */

?>
@extends($template.'layout',['title' => $model->title ?? ''])
@section('content')
    <main class="isotope__container unselectable">
        <div class="light-wrapper">
            <div class="container-fluid">
                <div class="portfolio classic-masonry">
                    <div class="clearfix"></div>
                    <div class="row">
                        <?php if ($galleries = $model->manyGalleryWithImages){ ?>
                            <?php foreach ($galleries as $gallery){ ?>
                            <?php $images = $gallery->images; ?>
                            <?php foreach ($images as $image){ ?>
                        <div class="col-4 portfolio-item">
                            <figure>
                                <a
                                        href="<?= $image->getImage() ?>"
                                        data-fancybox="gallery"
                                        data-title-id="title-01">
                                    <div class="text-overlay"></div>
                                    <img data-js-image-lazy-loading="<?= $image->getImage() ?>" src="/img/11.gif"
                                         alt="<?= $image->title ?? 'Заголовок'?>"></a>
                            </figure>
                            <div id="title-01" class="info hidden">
                                <h2><?= $image->title ?? 'Заголовок' ?></h2>
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
