<?php

/* @var $url string
 * @var $model object
 */

?>
<div class="img block-image js-image-block">
    <?php if($url){ ?>
    <img data-fancybox src="<?= $url ?>" alt="">
    <div class="overlay-content text-center justify-content-end">
        <div class="btn-group mb-1" role="group">
            <a data-fancybox="gallery" href="<?= $url ?>">
                <button type="button" class="btn btn-link btn-icon text-danger">
                    <i class="material-icons">zoom_in</i>
                </button>
            </a>
            <button
                type="button"
                class="btn btn-link btn-icon text-danger"
                data-js-image-model="<?= $model->getTable() ?>"
                data-js-image-id="<?= $model->id ?>"
                data-js-image-array-id="<?= $model->id ?>">
                <i class="material-icons">delete</i>
            </button>
        </div>
    </div>
    <?php } ?>
</div>
