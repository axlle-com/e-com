<?php

use App\Common\Models\Catalog\Document\CatalogDocument;use App\Common\Models\Catalog\Document\CatalogDocumentContent;use App\Common\Models\Catalog\Document\CatalogDocumentSubject;use App\Common\Models\Catalog\Storage\CatalogStoragePlace;

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
                <input type="hidden" name="id" value="<?= $model->id ?? null ?>">
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
                                            <?php if($model->id ?? null){ ?>
                                                <button
                                                    type="button"
                                                    class="btn btn-warning js-catalog-document-posting">
                                                    Провести
                                                </button>
                                            <?php } ?>
                                            <button
                                                type="button"
                                                class="btn btn-primary js-catalog-document-content-add">
                                                Добавить позицию
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <fieldset class="form-block">
                                            <legend>Связь данных</legend>
                                            <div class="row">
                                                <div class="col-sm-6">
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
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php if(!empty($pid = CatalogStoragePlace::forSelect())){ ?>
                                                    <div class="form-group small">
                                                        <label for="blogTitle">Склад</label>
                                                        <select
                                                            class="form-control select2"
                                                            data-placeholder="Склад"
                                                            data-select2-search="true"
                                                            name="catalog_storage_place_id"
                                                            data-validator-required
                                                            data-validator="catalog_storage_place_id">
                                                            <option></option>
                                                            <?php foreach ($pid as $item){ ?>
                                                            <option
                                                                value="<?= $item['id'] ?>"
                                                                <?= ($item['id'] == $model->catalog_storage_place_id) ? 'selected' : ''?>>
                                                                <?= $item['title'] ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group small">
                                                        <label for="blogTitle">Основание</label>
                                                        <input
                                                            class="form-control"
                                                            data-placeholder="Основание"
                                                            name="catalog_storage_place_id"
                                                            data-validator="catalog_document_id">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="form-group small">
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-light"
                                                            data-toggle="modal"
                                                            data-action="/admin/catalog/ajax/index-document"
                                                            data-target="#xl-modal-document">Launch Modal</button>
                                                    </div>
                                                </div>
                                            </div>
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
        <div class="modal fade" id="xl-modal-document" aria-labelledby="xlModalLabel" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white shadow-none">
                        <h6 class="modal-title" id="xlModalLabel">Список документов</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
