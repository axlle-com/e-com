<?php

/**
 * @var $model Comment
 */

use App\Common\Models\Comment;

?>
<div id="comment-<?= $model->id ?>" class="comment ">
    <div class="comment-body">
        <div class="comment-header d-flex flex-wrap justify-content-between">
            <h4 class="comment-title"><?= $model->getDatAuthor() ?>
                <span class="review-date">
                <i class="fa fa-calendar" aria-hidden="true"></i><?= $model->getDate() ?>
            </span>
                <a href="javascript:void(0)" class="js-review-id" data-review-id="<?= $model->id ?>">Ответить</a>
            </h4>
        </div>
        <p class="comment-text"><?= $model->text ?></p>
    </div>
</div>

