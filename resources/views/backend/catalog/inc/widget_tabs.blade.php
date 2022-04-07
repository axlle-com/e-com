<?php

use App\Common\Models\Catalog\CatalogProduct;use App\Common\Models\Catalog\CatalogProductWidgets;use App\Common\Models\Catalog\CatalogProductWidgetsContent;

/* @var $title string
 * @var $tabs CatalogProductWidgetsContent[]
 * @var $widget CatalogProductWidgets
 * @var $model CatalogProduct
 */
$widget = $model->catalogProductWidgetsWithContent[0];
$tabs = $widget->catalogProductWidgetsContents;

?>
<div class="row">
    <input type="hidden" name="catalog_product_widgets_id" value="<?= $widget->id ?? null ?>">
    <?php if($tabs){ ?>
        <?php foreach ($tabs as $item) { ?>
            <input type="hidden" name="tabs[<?= $item->id ?>][id]" value="<?= $item->id ?>">
            <div class="col-sm-12 form-block">
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
                                        class="form-control summernote"><?= $item->description ?></textarea>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <fieldset class="form-block">
                            <legend>Изображение</legend>
                            <div class="block-image js-image-block">
                                <?php if($image = $item->getImage()) { ?>
                                    <img data-fancybox src="<?= $image ?>">
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label button-100" for="js-widgets-image-upload-<?= $item->id ?>">
                                    <a type="button" class="btn btn-primary button-image">Загрузить
                                        фото</a>
                                </label>
                                <input
                                    type="file"
                                    data-widgets-uuid="<?= $item->id ?>"
                                    id="js-widgets-image-upload-<?= $item->id ?>"
                                    class="custom-input-file js-widgets-image-upload"
                                    name="tabs[<?= $item->id ?>][image]"
                                    accept="image/*">
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
    <div class="col-sm-4 form-group">
        <a type="button" class="btn btn-primary button-image js-widgets-button-add">Добавить tab</a>
    </div>
</div>
