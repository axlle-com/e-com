<?php

use App\Common\Models\Catalog\CatalogPaymentType;
use App\Common\Models\Catalog\Document\DocumentBase;

/**
 * @var $model DocumentBase
 * @var
 */

?>

<?php if(!empty($pid = CatalogPaymentType::forSelect())){ ?>

<div class="col-sm-6">
    <div class="form-group small">
        <label for="blogTitle">Тип оплаты</label>
        <select
                class="form-control select2"
                data-placeholder="Тип оплаты"
                data-select2-search="true"
                name="catalog_payment_type_id"
                data-validator-required
                data-validator="catalog_payment_type_id">
            <option></option>
                <?php foreach($pid as $item){ ?>
            <option value="<?= $item['id'] ?>"
                    <?= ($item['id'] == $model->catalog_payment_type_id) ? 'selected' : '' ?>>
                    <?= $item['title'] ?>
            </option>
            <?php } ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
</div>
<?php } ?>
