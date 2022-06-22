<?php

use App\Common\Models\Catalog\Document\Main\DocumentBase;use App\Common\Models\Catalog\Storage\CatalogStoragePlace;

/**
 * @var $model DocumentBase
 * @var
 */

?>

<fieldset class="form-block">
    <legend>Основание</legend>
    <div class="form-group small">
        <h6></h6>
        <button
            type="button"
            class="btn btn-sm btn-light"
            data-toggle="modal"
            data-action="/admin/catalog/ajax/index-document"
            data-target-type="<?= $keyDocument ?? null ?>"
            data-target="#xl-modal-document">Добавить основание
        </button>
        <button
            type="button"
            class="btn btn-sm btn-light js-document-target-remove">
            Удалить основание
        </button>
    </div>
</fieldset>

