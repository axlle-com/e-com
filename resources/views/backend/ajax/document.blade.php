<?php

/* @var $title string
 * @var $models CatalogDocument[]
 * @var $post array
 */

use App\Common\Models\Catalog\Document\CatalogDocument;

?>

<div class="main-body a-document-index js-ajax">
    <div class="card js-document">
        <div class="card-body js-document-inner">
            @include('backend.document.inc.document_index', ['models' => $models,'isAjax' => true])
        </div>
    </div>
</div>
