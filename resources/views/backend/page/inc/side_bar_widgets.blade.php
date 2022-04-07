<?php

use App\Common\Models\InfoBlock;
use App\Common\Models\Menu\Menu;
use App\Common\Models\Widgets\Widgets;

/* @var $title string
 * @var $model object
 */

?>
<?php if(!empty($pid = Menu::forSelect())){ ?>
<fieldset class="form-block">
    <legend>Меню</legend>
    <div class="form-group">
        <select
            class="form-control select2"
            name="menus[]"
            id="menu"
            data-validator="menus"
            multiple
            data-placeholder="Выберете меню">
            <?php foreach ($pid as $item){ ?>
            <option
                value="<?= $item['id'] ?>" <?= ($item['id'] === $model->render_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
            <?php } ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
</fieldset>
<?php } ?>
<?php if(!empty($pid = Widgets::forSelect())){ ?>
<fieldset class="form-block">
    <legend>Виджеты</legend>
    <div class="form-group">
        <select
            class="form-control select2"
            name="widgets[]"
            id="widgets"
            data-validator="widgets"
            multiple
            data-placeholder="Выберете виджет">
            <?php foreach ($pid as $item){ ?>
            <option
                value="<?= $item['id'] ?>" <?= ($item['id'] === $model->render_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
            <?php } ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
</fieldset>
<?php } ?>
<?php if(!empty($pid = InfoBlock::forSelect())){ ?>
<fieldset class="form-block">
    <legend>Инфоблоки</legend>
    <div class="form-group">
        <select
            class="form-control select2"
            name="info_blocks[]"
            id="info_block"
            data-validator="info_blocks"
            multiple
            data-placeholder="Выберете инфоблок">
            <?php foreach ($pid as $item){ ?>
            <option
                value="<?= $item['id'] ?>" <?= ($item['id'] === $model->render_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
            <?php } ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
</fieldset>
<?php } ?>
