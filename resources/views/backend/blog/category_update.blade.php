<?php

use App\Common\Models\Blog\PostCategory;
use App\Common\Models\InfoBlock;
use App\Common\Models\Menu;
use App\Common\Models\Render;
use App\Common\Models\Widgets;

/* @var $title string
 * @var $breadcrumb string
 * @var $model PostCategory
 */

$title = $title ?? 'Заголовок';

?>
@extends('backend.layout',['title' => $title])
@section('content')
    <div class="main-body blog-category js-image">
        <?= $breadcrumb ?>
        <h5><?= $title ?></h5>
        <div>
            <form id="global-form">
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
                                           href="#homeFaded"
                                           role="tab"
                                           aria-controls="homeFaded"
                                           aria-selected="false">Основное</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-faded"
                                           id="profile-tab-faded"
                                           data-toggle="tab"
                                           href="#profileFaded"
                                           role="tab"
                                           aria-controls="profileFaded"
                                           aria-selected="false">Галерея</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-faded"
                                           id="contact-tab-faded"
                                           data-toggle="tab"
                                           href="#contactFaded"
                                           role="tab"
                                           aria-controls="contactFaded"
                                           aria-selected="true">Настройки</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="homeFaded" role="tabpanel" aria-labelledby="home-tab-faded">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <fieldset class="form-block">
                                                <legend>Связь данных</legend>
                                                <?php if(!empty($pid = PostCategory::forSelect())){ ?>
                                                <div class="form-group small">
                                                    <label for="blogTitle">Категория</label>
                                                    <select
                                                        class="form-control select2"
                                                        data-placeholder="Категория"
                                                        data-select2-search="true"
                                                        name="category_id"
                                                        data-validator="category_id">
                                                        <option></option>
                                                        <?php foreach ($pid as $item){ ?>
                                                            <option value="<?= $item['id'] ?>" <?= ($item['id'] === $model->category_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <?php } ?>
                                                <?php if(!empty($pid = Render::byType($model))){ ?>
                                                <div class="form-group small">
                                                    <label for="blogTitle">Шаблон</label>
                                                    <select
                                                        class="form-control select2"
                                                        data-placeholder="Шаблон"
                                                        data-select2-search="true"
                                                        name="render_id"
                                                        data-validator="render_id">
                                                        <option></option>
                                                        <?php foreach ($pid as $item){ ?>
                                                        <option value="<?= $item['id'] ?>" <?= ($item['id'] === $model->render_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <?php } ?>
                                            </fieldset>
                                            <fieldset class="form-block">
                                                <legend>Заголовок</legend>
                                                <div class="form-group small">
                                                    <label for="blogTitle">Обычный</label>
                                                    <input
                                                        class="form-control form-shadow"
                                                        placeholder="Обычный"
                                                        name="title"
                                                        id="title"
                                                        value="<?= $model->title ?>"
                                                        data-validator="title">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group small">
                                                    <label for="blogTitle">Алиас</label>
                                                    <input
                                                        class="form-control form-shadow"
                                                        placeholder="Алиас"
                                                        name="alias"
                                                        id="alias"
                                                        value="<?= $model->alias ?>"
                                                        data-validator="alias">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group small">
                                                    <label for="blogTitle">Короткий</label>
                                                    <input
                                                        class="form-control form-shadow"
                                                        placeholder="Короткий"
                                                        name="title_short"
                                                        id="title_short"
                                                        value="<?= $model->title_short ?>"
                                                        data-validator="title_short">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-block">
                                                <legend>SEO</legend>
                                                <div class="form-group small">
                                                    <label for="blogTitle">Заголовок SEO</label>
                                                    <input
                                                        class="form-control form-shadow"
                                                        placeholder="Заголовок SEO"
                                                        name="title_seo"
                                                        id="title_seo"
                                                        value="<?= $model->title_seo ?>"
                                                        data-validator="title_seo">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group small">
                                                    <label for="blogTitle">Описание SEO</label>
                                                    <textarea
                                                        class="form-control form-shadow"
                                                        placeholder="Описание SEO"
                                                        name="description_seo"
                                                        id="description_seo"
                                                        data-validator="description_seo"><?= $model->description_seo ?></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </fieldset>
                                            <div class="form-group small">
                                        <textarea
                                            name="description"
                                            id="description"
                                            class="form-control summernote"><?= $model->description ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <fieldset class="form-block">
                                                <legend>Изображение</legend>
                                                <div class="block-image js-image-block">
                                                    <?php if($image = $model->getImage()) { ?>
                                                        <img src="<?= $image ?>">
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label button-100" for="js-image-upload">
                                                        <a type="button" class="btn btn-primary button-image">Загрузить фото</a>
                                                    </label>
                                                    <input
                                                        type="file"
                                                        id="js-image-upload"
                                                        class="custom-input-file"
                                                        name="image"
                                                        accept="image/*">
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="show_image" value="<?= $model->show_image ?>" id="customCheck1">
                                                        <label class="custom-control-label" for="customCheck1">Отобразить изображение</label>
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
                                                        value="<?= $model->createdAt() ?>"
                                                        placeholder="Укажите дату"
                                                        autocomplete="off"
                                                        data-input>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-light btn-icon" type="button" title="Choose date" data-toggle><i class="material-icons">calendar_today</i></button>
                                                        <button class="btn btn-light btn-icon" type="button" title="Clear" data-clear><i class="material-icons">close</i></button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            name="is_published"
                                                            value="<?= $model->is_published ?>"
                                                            id="customCheckIsPublished">
                                                        <label class="custom-control-label" for="customCheckIsPublished">Опубликовано</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            name="is_favourites"
                                                            value="<?= $model->is_favourites ?>"
                                                            id="customCheckIsFavourites">
                                                        <label class="custom-control-label" for="customCheckIsFavourites">Избранное</label>
                                                    </div>
                                                </div>
                                            </fieldset>

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
                                                            <option value="<?= $item['id'] ?>" <?= ($item['id'] === $model->render_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
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
                                                        <option value="<?= $item['id'] ?>" <?= ($item['id'] === $model->render_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
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
                                                            <option value="<?= $item['id'] ?>" <?= ($item['id'] === $model->render_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </fieldset>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profileFaded" role="tabpanel" aria-labelledby="profile-tab-faded">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="parts-gallery js-gallery-block-saved">
                                                <?php if(($gallery = $model?->galleryWithImages[0]?->images) && $gallery->isNotEmpty()){ ?>
                                                    <?php foreach ($gallery as $image){ ?>
                                                        <input
                                                            type="hidden"
                                                            placeholder="Заголовок"
                                                            name="images[<?= $image->id ?>][id]"
                                                            value="<?= $image->id ?>">
                                                        <div class="md-block-5 js-gallery-item">
                                                            <div class="img rounded">
                                                                <img src="<?= $image->url ?>" alt="Image">
                                                                <div class="overlay-content text-center justify-content-end">
                                                                    <div class="btn-group mb-1" role="group">
                                                                        <a data-fancybox="gallery" href="<?= $image->url ?>">
                                                                            <button type="button" class="btn btn-link btn-icon text-danger">
                                                                                <i class="material-icons">zoom_in</i>
                                                                            </button>
                                                                        </a>
                                                                        <button type="button" class="btn btn-link btn-icon text-danger" data-js-image-array-id="${key}">
                                                                            <i class="material-icons">delete</i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="form-group small">
                                                                    <input
                                                                        class="form-control form-shadow"
                                                                        placeholder="Заголовок"
                                                                        name="images[<?= $image->id ?>][title]"
                                                                        value="<?= $image->title ?>">
                                                                    <div class="invalid-feedback"></div>
                                                                </div>
                                                                <div class="form-group small">
                                                                    <input
                                                                        class="form-control form-shadow"
                                                                        placeholder="Описание"
                                                                        name="images[<?= $image->id ?>][description]"
                                                                        value="<?= $image->description ?>">
                                                                    <div class="invalid-feedback"></div>
                                                                </div>
                                                                <div class="form-group small">
                                                                    <input
                                                                        class="form-control form-shadow"
                                                                        placeholder="Сортировка"
                                                                        name="images[<?= $image->id ?>][sort]"
                                                                        value="<?= $image->sort ?>">
                                                                    <div class="invalid-feedback"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-12 parts-gallery js-gallery-block"></div>
                                            <div class="col-sm-4 form-group">
                                                <label class="control-label button-100" for="js-gallery-input">
                                                    <a type="button" class="btn btn-primary button-image">Загрузить фото</a>
                                                </label>
                                                <input
                                                    type="file"
                                                    id="js-gallery-input"
                                                    class="custom-input-file js-blog-category-gallery-input"
                                                    name=""
                                                    multiple
                                                    accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contactFaded" role="tabpanel" aria-labelledby="contact-tab-faded">
                                    contact content here
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
