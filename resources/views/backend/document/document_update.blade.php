<?php

/* @var $title string
 * @var $keyDocument string
 * @var $breadcrumb string
 * @var $model DocumentBase
 * @var $content DocumentContentBase
 */

use App\Common\Models\Catalog\Document\DocumentComing;use App\Common\Models\Catalog\Document\Main\DocumentBase;use App\Common\Models\Catalog\Document\Main\DocumentContentBase;

$title = $title ?? 'Заголовок';
$contents = $model->contents ?? [];
$data = ['model' => $model, 'keyDocument' => $keyDocument];
$views = [
    'target' => view('backend.document.inc.target', $data),
    'storage' => view('backend.document.inc.storage', $data),
    'counterparty' => view('backend.document.inc.counterparty', $data),
    'storage_target' => view('backend.document.inc.storage_target', $data),
    'expired_at' => view('backend.document.inc.expired_at', $data),
];
$string = '';
foreach ($model::$fields as $field) {
    $string .= $views[$field];
}

?>
@extends('backend.layout',['title' => $title])
@section('content')
    <div class="main-body a-document js-image">
        <?= $breadcrumb ?>
        <h5><?= $title ?></h5>
        <div>
            <form id="global-form" action="/admin/catalog/ajax/save-document">
                <input type="hidden" name="id" value="<?= $model->id ?? null ?>">
                <input type="hidden" name="type" value="<?= $keyDocument ?>">
                <input type="hidden" name="document_id" value="<?= $model->document_id ?? ''?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="list-with-gap mb-2">
                                            <button type="button" class="btn btn-success js-save-button">Сохранить
                                            </button>
                                            <a type="button" class="btn btn-secondary"
                                               href="/admin/catalog/document/<?= $keyDocument ?>">Выйти</a>
                                            <?php if($model->id ?? null){ ?>
                                            <button
                                                type="button"
                                                class="btn btn-warning js-catalog-document-posting">
                                                Провести
                                            </button>
                                            <?php } ?>
                                            <button
                                                type="button"
                                                <?= $model instanceof DocumentComing ? 'data-price-out="1"' : '' ?>
                                                class="btn btn-primary js-catalog-document-content-add">
                                                Добавить позицию
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-primary js-catalog-document-product-all">
                                                Выбрать товары
                                            </button>
                                        </div>
                                    </div>
                                    <?php if($string){ ?>
                                    <div class="col-sm-12">
                                        <fieldset class="form-block">
                                            <legend>Связь данных</legend>
                                            <div class="row">
                                                <?= $string ?>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 js-catalog-document-content-inner">
                                        <?php if(count($contents)){ ?>
                                        <?php foreach ($contents as $content){ ?>
                                        @include('backend.document.inc.document_content', ['model' => $content])
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
