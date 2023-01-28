<?php

use App\Common\Models\Page\Page;
use App\Common\Models\Render;

/**
 * @var $title string
 * @var $model Page
 */

?>
<div class="col-sm-8">
    <fieldset class="form-block">
        <legend>Связь данных</legend>
        <?php if (!empty($pid = Render::byType($model))){ ?>
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
                <option
                        value="<?= $item['id'] ?>" <?= ($item['id'] == $model->render_id) ? 'selected' : '' ?>><?= $item['title'] ?></option>
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
                    name="seo[title]"
                    id="title_seo"
                    value="<?= $model->title_seo ?>"
                    data-validator="seo.title">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group small">
            <label for="blogTitle">Описание SEO</label>
            <textarea
                    class="form-control form-shadow"
                    placeholder="Описание SEO"
                    name="seo[description]"
                    id="description_seo"
                    data-validator="seo.description"><?= $model->description_seo ?></textarea>
            <div class="invalid-feedback"></div>
        </div>
    </fieldset>
    <div class="form-group small">
        <textarea
                name="description"
                id="description"
                class="form-control summernote-500"><?= $model->description ?></textarea>
    </div>
</div>
