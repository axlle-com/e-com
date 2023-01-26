<?php

/* @var $title string
 * @var $post array
 */


?>

<div class="main-body a-document-index js-ajax">
    <div class="card js-document">
        <div class="card-body js-document-inner">
            @include('backend.document.inc.document_index', ['models' => $models,'isAjax' => true])
        </div>
    </div>
</div>
