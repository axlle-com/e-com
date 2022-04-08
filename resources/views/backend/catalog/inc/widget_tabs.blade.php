<?php

use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Catalog\CatalogProductWidgets;
use App\Common\Models\Catalog\CatalogProductWidgetsContent;

/* @var $title string
 * @var $tabs CatalogProductWidgetsContent[]
 * @var $widget CatalogProductWidgets
 * @var $model CatalogProduct
 */

$widget = $model->widgetTabs;
$tabs = $widget->content ?? [];

?>
<div class="row">
    <input type="hidden"
           name="catalog_product_widgets_id[<?= CatalogProductWidgets::WIDGET_TABS ?>]"
           value="<?= $widget->id ?? null ?>">
    <?php if($tabs){ ?>
    <?php foreach ($tabs as $item) { ?>
    <div class="col-sm-12 form-block widget-tabs">
        <input type="hidden" name="tabs[<?= $item->id ?>][id]" value="<?= $item->id ?>">
        <div class="row">
            <div class="col-sm-8 widgets-tabs js-widgets-tabs">
                <div>
                    <fieldset class="form-block">
                        <legend>Наполнение</legend>
                        <div class="form-group small">
                            <input
                                class="form-control form-shadow"
                                placeholder="Заголовок"
                                name="tabs[<?= $item->id ?>][title]"
                                value="<?= $item->title ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group small">
                            <input
                                class="form-control form-shadow"
                                placeholder="Заголовок короткий"
                                name="tabs[<?= $item->id ?>][title_short]"
                                value="<?= $item->title_short ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group small">
                            <input
                                class="form-control form-shadow"
                                placeholder="Сортировка"
                                name="tabs[<?= $item->id ?>][sort]"
                                value="<?= $item->sort ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group small">
                            <textarea
                                id="description"
                                name="tabs[<?= $item->id ?>][description]"
                                class="form-control summernote">
                                <?= $item->description ?>
                            </textarea>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="col-sm-4">
                <fieldset class="form-block">
                    <legend>Изображение</legend>
                    @include('backend.inc.image', ['url' => $item->getImage() ?: '#','model' => $item])
                    <div class="form-group">
                        <label class="control-label button-100" for="js-image-upload-<?= $item->id ?>">
                            <a type="button" class="btn btn-primary button-image">Загрузить
                                фото</a>
                        </label>
                        <input
                            type="file"
                            id="js-image-upload-<?= $item->id ?>"
                            class="custom-input-file js-image-upload"
                            name="tabs[<?= $item->id ?>][image]"
                            accept="image/*">
                    </div>
                </fieldset>
            </div>
            <button
                type="button"
                class="close widget"
                data-dismiss="alert"
                data-js-widget-model="<?= $item->getTable() ?>"
                data-js-widget-id="<?= $item->id ?>"
                data-js-widget-array-id="<?= $item->id ?>"
                aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="col-sm-4 form-group">
        <a type="button" class="btn btn-primary button-image js-widgets-button-add">Добавить tab</a>
    </div>
</div>
