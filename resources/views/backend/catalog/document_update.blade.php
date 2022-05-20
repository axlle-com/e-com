<?php

use App\Common\Models\Catalog\CatalogDocument;use App\Common\Models\Catalog\CatalogDocumentContent;use App\Common\Models\Catalog\CatalogDocumentSubject;

/* @var $title string
 * @var $breadcrumb string
 * @var $model CatalogDocument
 * @var $content CatalogDocumentContent
 */

$title = $title ?? 'Заголовок';

$contents = $model->contents ?? [];

?>
@extends('backend.layout',['title' => $title])
@section('content')
    <div class="main-body a-document js-image">
        <?= $breadcrumb ?>
        <h5><?= $title ?></h5>
        <div>
            <form id="global-form" action="/admin/catalog/ajax/save-document">
                <input type="hidden" name="id" value="<?= $model->id ?? null?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="list-with-gap mb-2">
                                            <button type="button" class="btn btn-success js-save-button">Сохранить
                                            </button>
                                            <a type="button" class="btn btn-secondary" href="/admin/catalog/document">Выйти</a>
                                            <button
                                                type="button"
                                                class="btn btn-primary js-catalog-document-content-add">
                                                Добавить позицию
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <fieldset class="form-block">
                                            <legend>Связь данных</legend>
                                            <?php if(!empty($pid = CatalogDocumentSubject::forSelect())){ ?>
                                            <div class="form-group small">
                                                <label for="blogTitle">Тип документа</label>
                                                <select
                                                    class="form-control select2"
                                                    data-placeholder="Тип"
                                                    data-select2-search="true"
                                                    name="catalog_document_subject_id"
                                                    data-validator-required
                                                    data-validator="catalog_document_subject_id">
                                                    <option></option>
                                                    <?php foreach ($pid as $item){ ?>
                                                    <option
                                                        value="<?= $item['id'] ?>" <?= ($item['id'] == $model->catalog_document_subject_id) ? 'selected' : ''?>><?= $item['title'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <?php } ?>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 js-catalog-document-content-inner">
                                        <?php if(count($contents)){ ?>
                                        <?php foreach ($contents as $content){ ?>
                                        @include('backend.catalog.inc.document_content', ['model' => $content])
                                        <?php } ?>
                                        <?php } ?>
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
