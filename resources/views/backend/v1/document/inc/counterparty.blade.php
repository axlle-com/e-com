<?php

use App\Common\Models\Catalog\Document\DocumentBase;
use App\Common\Models\User\Counterparty;

/**
 * @var $model DocumentBase
 * @var
 */

?>

<?php if(!empty($pid = Counterparty::forSelect())){ ?>
<div class="col-sm-6">
    <div class="form-group small">
        <label for="blogTitle">Контрагент</label>
        <select
                class="form-control select2"
                data-placeholder="Контрагент"
                data-select2-search="true"
                name="counterparty_id"
                data-validator-required
                data-validator="counterparty_id">
            <option></option>
                <?php foreach($pid as $item){ ?>
            <option value="<?= $item['id'] ?>"
                    <?= ($item['id'] == $model->counterparty_id) ? 'selected' : '' ?>>
                    <?= $item['name'] ?: $item['user_name'] ?>
            </option>
            <?php } ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
</div>
<?php } ?>
