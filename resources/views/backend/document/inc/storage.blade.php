<?php

use App\Common\Models\Catalog\Document\Main\DocumentBase;use App\Common\Models\Catalog\Storage\CatalogStoragePlace;

/**
 * @var $model DocumentBase
 * @var
 */

?>
<div class="col-sm-6">
<?php if(!empty($pid = CatalogStoragePlace::forSelect())){ ?>
<div class="form-group small">
    <label for="blogTitle">Склад</label>
    <select
        class="form-control select2"
        data-placeholder="Склад"
        data-select2-search="true"
        name="catalog_storage_place_id"
        data-validator-required
        data-validator="catalog_storage_place_id">
        <option></option>
        <?php foreach ($pid as $item){ ?>
        <option
            value="<?= $item['id'] ?>"
        <?= ($item['id'] == $model->catalog_storage_place_id) ? 'selected' : ''?>>
            <?= $item['title'] ?>
        </option>
        <?php } ?>
    </select>
    <div class="invalid-feedback"></div>
</div>
<?php } ?>
</div>
