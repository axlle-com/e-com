<?php

use App\Common\Models\Catalog\CatalogProduct;

/* @var $title string
 * @var $breadcrumb string
 * @var $model CatalogProduct
 */

$title = $title ?? 'Заголовок';
$tabs = new stdClass();
?>
@extends('backend.layout',['title' => $title])
@section('content')
    <div class="main-body blog-category js-image">
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
                                               href="#homeFaded"
                                               role="tab"
                                               aria-controls="homeFaded"
                                               aria-selected="false">Основное</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-faded"
                                               id="profile-tab-faded"
                                               data-toggle="tab"
                                               href="#tab2Faded"
                                               role="tab"
                                               aria-controls="tab2Faded"
                                               aria-selected="false">Галерея</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-faded"
                                               id="contact-tab-faded"
                                               data-toggle="tab"
                                               href="#tab3Faded"
                                               role="tab"
                                               aria-controls="tab3Faded"
                                               aria-selected="true">Настройки</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-link-faded"
                                               id="contact-tab-faded"
                                               data-toggle="tab"
                                               href="#tab4Faded"
                                               role="tab"
                                               aria-controls="tab4Faded"
                                               aria-selected="true">Виджет Tabs</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="homeFaded" role="tabpanel"
                                         aria-labelledby="home-tab-faded">
                                        <div class="row">
                                            @include('backend.catalog.inc.front_page')
                                            <div class="col-sm-4">
                                                <fieldset class="form-block">
                                                    <legend>Изображение</legend>
                                                    <div class="block-image js-image-block">
                                                        <?php if($image = $model->getImage()) { ?>
                                                        <img data-fancybox src="<?= $image ?>">
                                                        <?php } ?>
                                                    </div>
                                                    <div class="form-group">
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
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-block">
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
                                                    <legend>Публикация</legend>
                                                    <div class="input-group datepicker-wrap form-group">
                                                        <label for="blogTitle">Дата публикации</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="date_pub"
                                                            value="<?= date('d.m.Y', $model->created_at) ?>"
                                                            placeholder="Укажите дату"
                                                            autocomplete="off"
                                                            data-input>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-light btn-icon" type="button"
                                                                    title="Choose date" data-toggle><i
                                                                    class="material-icons">calendar_today</i></button>
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
                                                                id="is_published"
                                                            <?= $model->is_published ? 'checked' : ''?>>
                                                            <label class="custom-control-label" for="is_published">Опубликовано</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                class="custom-control-input"
                                                                name="show_date"
                                                                id="show_date"
                                                            <?= $model->show_date ? 'checked' : ''?>>
                                                            <label class="custom-control-label" for="show_date">Показывать
                                                                дату в посте</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                class="custom-control-input"
                                                                name="is_favourites"
                                                                id="is_favourites"
                                                            <?= $model->is_favourites ? 'checked' : ''?>>
                                                            <label class="custom-control-label" for="is_favourites">Избранное</label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                @include('backend.catalog.inc.side_bar_widgets')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2Faded" role="tabpanel"
                                         aria-labelledby="profile-tab-faded">
                                        @include('backend.catalog.inc.gallery_page')
                                    </div>
                                    <div class="tab-pane fade" id="tab3Faded" role="tabpanel"
                                         aria-labelledby="contact-tab-faded">
                                        Settings
                                    </div>
                                    <div class="tab-pane fade" id="tab4Faded" role="tabpanel"
                                         aria-labelledby="contact-tab-faded">
                                        @include('backend.catalog.inc.widget_tabs')
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
