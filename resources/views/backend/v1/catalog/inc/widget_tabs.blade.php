<?php

use App\Common\Models\Catalog\Product\CatalogProduct;use App\Common\Models\Catalog\Product\CatalogProductWidgets;use App\Common\Models\Catalog\Product\CatalogProductWidgetsContent;

/** @var $title string
 * @var $tabs CatalogProductWidgetsContent[]
 * @var $widget CatalogProductWidgets
 * @var $model \App\Common\Models\Catalog\Product\CatalogProduct
 */

$widget = $model->widgetTabs;
$tabs = $widget->content ?? [];

?>
<div class="catalog-tabs">
    <div class="row">
        <div class="col-md-12">
            <button
                type="button"
                class="btn btn-primary catalog-tabs-add js-widgets-button-add">Добавить widget</button>
        </div>
    </div>
    <div class="row widget-tabs-block">
        <input type="hidden"
               name="catalog_product_widgets_id"
               value="<?= $widget->id ?? null ?>">
        <?php if($tabs){ ?>
        <?php foreach ($tabs as $item) { ?>
        <div class="col-sm-12 widget-tabs mb-4">
            <div class="card h-100">
                <input type="hidden" name="tabs[<?= $item->id ?>][id]" value="<?= $item->id ?>">
                <div class="card-header">
                    Свойство
                    <div class="btn-group btn-group-sm ml-auto" role="group">
                        <button type="button" class="btn btn-light btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-plus">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-light btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-light btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-trash">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown ml-1">
                        <button class="btn btn-sm btn-light btn-icon dropdown-toggle no-caret" type="button"
                                id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">arrow_drop_down</i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" style="">
                            <button class="dropdown-item" type="button">Action</button>
                            <button class="dropdown-item" type="button">Another action</button>
                            <button class="dropdown-item" type="button">Something else here</button>
                        </div>
                    </div>
                    <button
                        type="button"
                        data-dismiss="alert"
                        data-js-widget-model="<?= $item->getTable() ?>"
                        data-js-widget-id="<?= $item->id ?>"
                        data-js-widget-array-id="<?= $item->id ?>"
                        class="ml-1 btn btn-sm btn-light btn-icon">
                        <i class="material-icons">close</i>
                    </button>
                </div>
                <div class="card-body">
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
                                @include($backendTemplate.'.inc.image', ['url' => $item->getImage() ?: '#','model' => $item])
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
                                    <div class="invalid-feedback"></div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>
