<?php

use App\Common\Models\Blog\Post;use App\Common\Models\Blog\PostCategory;use App\Common\Models\Catalog\CatalogCategory;use App\Common\Models\Catalog\CatalogProduct;use App\Common\Models\Page\Page;

/* @var $title string
 * @var $model PostCategory|Post|CatalogCategory|CatalogProduct|Page
 */

$galleries = [];
if ($model instanceof PostCategory) {
    $galleries[] = $model->galleryWithImages ?? [];
} elseif ($model instanceof Post) {
    $galleries = $model->manyGalleryWithImages ?? [];
} elseif ($model instanceof CatalogCategory) {
    $galleries[] = $model->galleryWithImages ?? [];
} elseif ($model instanceof CatalogProduct) {
    $galleries = $model->manyGalleryWithImages ?? [];
} elseif ($model instanceof Page) {
    $galleries = $model->manyGalleryWithImages ?? [];
}

?>
<div class="row">
    <div class="col-sm-12">
        <div class="parts-gallery js-gallery-block-saved">
            <?php if($galleries){ ?>
            <?php foreach ($galleries as $gallery){ ?>
            <?php if($gallery) { ?>
            <?php foreach ($gallery->images as $image){ ?>
            <div class="md-block-5 js-gallery-item">
                <div class="img rounded">
                    <input
                        type="hidden"
                        name="images[<?= $image->id ?>][id]"
                        value="<?= $image->id ?>">
                    @include('backend.inc.image', ['url' => $image->url,'model' => $image])
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
