<?php

use App\Common\Models\Catalog\Document\DocumentReservation;

/**
 * @var $model DocumentReservation
 * @var
 */

?>
<div class="col-sm-6">
    <div class="input-group datepicker-wrap form-group">
        <label class="input-clearable input-icon input-icon-sm input-icon-right">
            Резерв до
        </label>
        <input
            type="text"
            class="form-control"
            name="expired_at"
            value="<?= !empty($model['expired_at']) ? date('d.m.Y H:i:s',$model['expired_at']) : '' ?>"
            placeholder="Резерв до"
            autocomplete="off"
            data-input>
        <div class="input-group-append">
            <button class="btn btn-light btn-icon" type="button" title="Choose date" data-toggle><i class="material-icons">calendar_today</i></button>
            <button class="btn btn-light btn-icon" type="button" title="Clear" data-clear><i class="material-icons">close</i></button>
        </div>
        <div class="invalid-feedback"></div>
    </div>
</div>
