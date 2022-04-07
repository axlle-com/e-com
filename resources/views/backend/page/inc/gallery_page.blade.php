<?php

use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Page\Page;

/* @var $title string
 * @var $model Page
 * @var $image GalleryImage
 */

$galleries = $model->galleryWithImages ?? [];

?>
<div class="row">
    <div class="col-sm-12">
        <div class="parts-gallery js-gallery-block-saved">
            <?php if($galleries){ ?>
            <?php foreach ($galleries as $gallery){ ?>
            <?php if($gallery) { ?>
            <?php foreach ($gallery->images as $image){ ?>
            <input
                type="hidden"
                name="images[<?= $image->id ?>][id]"
                value="<?= $image->id ?>">
            <div class="md-block-5 js-gallery-item">
                <div class="img rounded">
                    <img src="<?= $image->url ?>" alt="Image">
                    <div class="overlay-content text-center justify-content-end">
                        <div class="btn-group mb-1" role="group">
                            <a data-fancybox="gallery" href="<?= $image->url ?>">
                                <button type="button" class="btn btn-link btn-icon text-danger">
                                    <i class="material-icons">zoom_in</i>
                                </button>
                            </a>
                            <button
                                type="button"
                                class="btn btn-link btn-icon text-danger"
                                data-js-image-id="<?= $image->id ?>"
                                data-js-image-array-id="<?= $image->id ?>">
                                <i class="material-icons">delete</i>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-group small">
                        <input
                            class="form-control form-shadow"
                            placeholder="Заголовок"
                            name="images[<?= $image->id ?>][title]"
                            value="<?= $image->title ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group small">
                        <input
                            class="form-control form-shadow"
                            placeholder="Описание"
                            name="images[<?= $image->id ?>][description]"
                            value="<?= $image->description ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group small">
                        <input
                            class="form-control form-shadow"
                            placeholder="Сортировка"
                            name="images[<?= $image->id ?>][sort]"
                            value="<?= $image->sort ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-sm-12 parts-gallery js-gallery-block"></div>
            <div class="col-sm-4 form-group">
                <label class="control-label button-100" for="js-gallery-input">
                    <a type="button" class="btn btn-primary button-image">Загрузить фото</a>
                </label>
                <input
                    type="file"
                    id="js-gallery-input"
                    class="custom-input-file js-blog-category-gallery-input"
                    name=""
                    multiple
                    accept="image/*">
            </div>
        </div>
    </div>
</div>
