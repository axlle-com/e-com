<?php

/** @var $title string
 * @var $breadcrumb string
 * @var $model CatalogProduct
 */

use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Setting\Setting;



$title = $title ?? 'Заголовок';

?>
@extends($layout,['title' => $title])
@section('content')
    <div class="main-body a-product js-image">
        <?= $breadcrumb ?>
        <h5><?= $title ?></h5>
        <div>
            <form id="global-form" action="/admin/catalog/ajax/save-product">
                <input type="hidden" name="id" value="<?= $model->id ?? null?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-with-gap mb-2">
                                    <button type="button" class="btn btn-success js-save-button">Сохранить</button>
                                    <a type="button" class="btn btn-secondary" href="/admin/catalog/product">Выйти</a>
                                </div>
                                <div class="list-with-gap mb-2">
                                    <ul class="nav nav-gap-x-1 mt-3" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-faded active"
                                               id="home-tab-faded"
                                               data-toggle="tab"
                                               href="#home-page"
                                               role="tab"
                                               aria-controls="home-page"
                                               aria-selected="false">Основное</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-faded"
                                               id="profile-tab-faded"
                                               data-toggle="tab"
                                               href="#tab5Faded"
                                               role="tab"
                                               aria-controls="tab5Faded"
                                               aria-selected="false">Свойства</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-faded"
                                               id="g-tab-faded"
                                               data-toggle="tab"
                                               href="#tab2Faded"
                                               role="tab"
                                               aria-controls="tab2Faded"
                                               aria-selected="false">Галерея</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-faded"
                                               id="t-tab-faded"
                                               data-toggle="tab"
                                               href="#tab4Faded"
                                               role="tab"
                                               aria-controls="tab4Faded"
                                               aria-selected="true">Виджет Tabs</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-faded"
                                               id="s-tab-faded"
                                               data-toggle="tab"
                                               href="#tab3Faded"
                                               role="tab"
                                               aria-controls="tab3Faded"
                                               aria-selected="true">Настройки</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="home-page" role="tabpanel"
                                         aria-labelledby="home-tab-faded">
                                        <div class="row">
                                            @include($backendTemplate.'.catalog.inc.front_page')
                                            <div class="col-sm-4 mb-3">
                                                <div class="card overflow-hidden mb-3 price">
                                                    <div class="card-header">
                                                        Стоимость
                                                        <div class="list-with-gap ml-auto">
                                                            <div
                                                                class="custom-control custom-control-nolabel custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       id="customSwitch">
                                                                <label class="custom-control-label"
                                                                       for="customSwitch"></label>
                                                            </div>
                                                            <button type="button"
                                                                    class="ml-1 btn btn-sm btn-light btn-icon">
                                                                <i class="material-icons">refresh</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body js-currency-block price">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Цена Входящая</span>
                                                            </div>
                                                            <input type="number"
                                                                   name="price_in"
                                                                   data-validator-required
                                                                   data-validator="price"
                                                                   class="form-control form-shadow"
                                                                   value="<?= $model->getPrice() ?>">
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Цена Продажи</span>
                                                            </div>
                                                            <input type="number"
                                                                   name="price_out"
                                                                   data-validator-required
                                                                   data-validator="price_out"
                                                                   class="form-control form-shadow js-action"
                                                                   value="<?= $model->getPrice() ?>">
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">USD</span>
                                                            </div>
                                                            <input type="text" name="840"
                                                                   data-currency-code="840"
                                                                   class="form-control form-shadow" disabled value="">
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">EUR</span>
                                                            </div>
                                                            <input type="text" name="978"
                                                                   data-currency-code="978"
                                                                   class="form-control form-shadow" disabled value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <fieldset class="form-block">
                                                    <legend>Изображение</legend>
                                                    @include($backendTemplate.'.inc.image', ['url' => $model->getImage(),'model' => $model,'gallery' => false])
                                                    <label class="control-label button-100" for="js-image-upload">
                                                        <a type="button" class="btn btn-primary button-image">Загрузить
                                                            фото</a>
                                                    </label>
                                                    <input
                                                        type="file"
                                                        id="js-image-upload"
                                                        class="custom-input-file js-image-upload"
                                                        name="image"
                                                        accept="image/*">
                                                    <div class="invalid-feedback"></div>
                                                </fieldset>
                                                <fieldset class="form-block">
                                                    <legend>Комментарии</legend>
                                                    <div class="custom-control custom-checkbox">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            name="is_comments"
                                                            id="is_comments"
                                                        <?= $model->is_comments ? 'checked' : ''?>>
                                                        <label class="custom-control-label" for="is_comments">Подключить
                                                            комментарии</label>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-block">
                                                    <legend>Приход</legend>
                                                    <div class="custom-control custom-checkbox">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            name="is_single"
                                                            id="is_single"
                                                        <?= $model->is_single ? 'checked' : ''?>>
                                                        <label class="custom-control-label" for="is_single">
                                                            Штучный товар
                                                        </label>
                                                    </div>
                                                    <?php if(!$model->is_published){ ?>
                                                    <div class="input-group datepicker-wrap form-group">
                                                        <label for="blogTitle">Дата прихода</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="created_at"
                                                            value="<?= date('d.m.Y', $model->created_at) ?>"
                                                            placeholder="Укажите дату"
                                                            autocomplete="off"
                                                            data-input>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-light btn-icon" type="button"
                                                                    title="Choose date" data-toggle><i
                                                                    class="material-icons">calendar_today</i>
                                                            </button>
                                                            <button class="btn btn-light btn-icon" type="button"
                                                                    title="Clear" data-clear><i class="material-icons">close</i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                class="custom-control-input"
                                                                name="is_published"
                                                                id="is_published">
                                                            <label class="custom-control-label" for="is_published">Оприходовано</label>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="input-group form-group">
                                                        <label>
                                                            Дата прихода
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="created_at"
                                                                value="<?= date('d.m.Y H:i:s', $model->created_at) ?>"
                                                                placeholder="Укажите дату"
                                                                autocomplete="off"
                                                                disabled>
                                                        </label>
                                                    </div>
                                                    <?php } ?>
                                                </fieldset>
                                                @include($backendTemplate.'.inc.side_bar_widgets')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab5Faded" role="tabpanel"
                                         aria-labelledby="profile-tab-faded">
                                        @include($backendTemplate.'.catalog.inc.setting_tabs')
                                    </div>
                                    <div class="tab-pane fade" id="tab2Faded" role="tabpanel"
                                         aria-labelledby="profile-tab-faded">
                                        @include($backendTemplate.'.inc.gallery')
                                    </div>
                                    <div class="tab-pane fade" id="tab4Faded" role="tabpanel"
                                         aria-labelledby="contact-tab-faded">
                                        @include($backendTemplate.'.catalog.inc.widget_tabs')
                                    </div>
                                    <div class="tab-pane fade" id="tab3Faded" role="tabpanel"
                                         aria-labelledby="contact-tab-faded">
                                        Settings
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
