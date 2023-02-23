<?php

use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Setting\Setting;



/** @var $title string
 * @var $breadcrumb string
 * @var $model      PostCategory
 */

$title = $title ?? 'Заголовок';

?>
@extends($layout,['title' => $title])
@section('content')
    <div class="main-body blog-category js-image">
        <?= $breadcrumb ?>
        <h5><?= $title ?></h5>
        <div>
            <form id="global-form" action="/admin/blog/ajax/save-category">
                <input type="hidden" name="id" value="<?= $model->id ?? null?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-with-gap mb-2">
                                    <button type="button" class="btn btn-success js-save-button">Сохранить</button>
                                    <a type="button" class="btn btn-secondary" href="/admin/blog/category">Выйти</a>
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
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="home-page" role="tabpanel"
                                         aria-labelledby="home-tab-faded">
                                        <div class="row">
                                            @include($backendTemplate.'.blog.inc.front_page')
                                            <div class="col-sm-4">
                                                <fieldset class="form-block">
                                                    <legend>Изображение</legend>
                                                    @include($backendTemplate.'.inc.image', ['url' => $model->getImage() ?: '','model' => $model])
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
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                    type="checkbox"
                                                                    class="custom-control-input"
                                                                    name="show_image"
                                                                    id="show_image"
                                                                <?= $model->show_image ? 'checked' : '' ?>>
                                                            <label class="custom-control-label" for="show_image">Отобразить
                                                                изображение</label>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-block">
                                                    <legend>Публикация</legend>
                                                    <div class="input-group datepicker-wrap form-group">
                                                        <input
                                                                type="text"
                                                                class="form-control"
                                                                name="created_at"
                                                                value="<?= $model->created_at ?>"
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
                                                                    id="customCheckIsPublished"
                                                                <?= $model->is_published ? 'checked' : '' ?>>
                                                            <label class="custom-control-label"
                                                                   for="customCheckIsPublished">Опубликовано</label>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                    type="checkbox"
                                                                    class="custom-control-input"
                                                                    name="is_favourites"
                                                                    id="customCheckIsFavourites"
                                                                <?= $model->is_favourites ? 'checked' : '' ?>>
                                                            <label class="custom-control-label"
                                                                   for="customCheckIsFavourites">Избранное</label>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                @include($backendTemplate.'.inc.side_bar_widgets')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2Faded" role="tabpanel"
                                         aria-labelledby="profile-tab-faded">
                                        @include($backendTemplate.'.inc.gallery')
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
