<?php

/* @var $title string
 * @var $model PostCategory|Post|CatalogCategory|CatalogProduct|Page
 */

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Page\Page;

$galleries = $model->manyGalleryWithImages ?? [];
//dd($galleries);
?>
<div class="catalog-tabs">
    <?php if($galleries){ ?>
    <?php foreach ($galleries as $gallery){ ?>
    <?php if($gallery) { ?>
    <div class="js-galleries-general-block">
        <input
            type="hidden"
            name="galleries[<?= $gallery->id ?>][gallery_id]"
            value="<?= $gallery->id ?>">
        <div class="row">
            <div class="col-md-12">
                <label class="control-label button-100" for="js-gallery-input-<?= $gallery->id ?>">
                    <a
                        type="button"
                        class="btn btn-primary catalog-tabs-add">
                        Загрузить фото</a>
                </label>
                <input
                    type="file"
                    id="js-gallery-input-<?= $gallery->id ?>"
                    data-js-gallery-id="<?= $gallery->id ?>"
                    class="custom-input-file js-blog-category-gallery-input js-gallery-input"
                    name=""
                    multiple
                    accept="image/*">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="parts-gallery js-gallery-block-saved">
                    <?php foreach ($gallery->images as $image){ ?>
                    <div class="md-block-5 js-gallery-item">
                        <div class="img rounded">
                            <input
                                type="hidden"
                                name="galleries[<?= $gallery->id ?>][images][<?= $image->id ?>][id]"
                                value="<?= $image->id ?>">
                            @include('backend.inc.image', ['url' => $image->getImage(),'model' => $image,'gallery' => true])
                        </div>
                        <div>
                            <div class="form-group small">
                                <input
                                    class="form-control form-shadow"
                                    placeholder="Заголовок"
                                    name="galleries[<?= $gallery->id ?>][images][<?= $image->id ?>][title]"
                                    value="<?= $image->title ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group small">
                                <input
                                    class="form-control form-shadow"
                                    placeholder="Описание"
                                    name="galleries[<?= $gallery->id ?>][images][<?= $image->id ?>][description]"
                                    value="<?= $image->description ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group small">
                                <input
                                    class="form-control form-shadow"
                                    placeholder="Сортировка"
                                    name="galleries[<?= $gallery->id ?>][images][<?= $image->id ?>][sort]"
                                    value="<?= $image->sort ?>">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    <div class="js-galleries-general-block">
        <div class="row">
            <div class="col-md-12">
                <label class="control-label button-100" for="js-gallery-input-0">
                    <a
                        type="button"
                        class="btn btn-primary catalog-tabs-add">
                        Загрузить фото</a>
                </label>
                <input
                    type="file"
                    id="js-gallery-input-0"
                    data-js-gallery-id=""
                    class="custom-input-file js-blog-category-gallery-input"
                    name=""
                    multiple
                    accept="image/*">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="parts-gallery js-gallery-block-saved"></div>
            </div>
        </div>
    </div>
</div>
