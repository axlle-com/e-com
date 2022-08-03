<?php

/* @var $title string
 * @var $models DocumentBase[]
 * @var $post array
 */

use App\Common\Models\Catalog\Document\Main\DocumentBase;

$title = $title ?? 'Заголовок';

?>
@extends('backend.layout',['title' => $title])

@section('content')
    <div class="main-body a-document-index js-index">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style3">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
        <h5><?= $title ?></h5>
        <div class="card js-document">
            <div class="card-body js-document-inner">
                <div class="btn-group btn-group-sm mb-3" role="group">
                    <a class="btn btn-light has-icon" href="/admin/catalog/document/<?= $keyDocument ?? null ?>-update">
                        <i class="material-icons mr-1">add_circle_outline</i>Новый документ
                    </a>
                    <a type="button" class="btn btn-light has-icon" href="/admin/catalog/document/<?= $keyDocument ?? null ?>">
                        <i class="material-icons mr-1">refresh</i>Обновить
                    </a>
                    <button type="button" class="btn btn-light has-icon">
                        <i class="mr-1" data-feather="paperclip"></i>Export
                    </button>
                    <button type="button" data-toggle="modal" data-target="#lgModal" class="btn btn-light has-icon">
                        <i class="material-icons mr-1">add_circle_outline</i>Быстрое создание
                    </button>
                </div>
                @include('backend.document.inc.document_index', ['models' => $models])
                <div class="modal fade" id="lgModal" tabindex="-1" role="dialog" aria-labelledby="lgModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white shadow-none">
                                <h6 class="modal-title" id="lgModalLabel">Произвольный счет на оплату</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group small">
                                            <label for="phone">Телефон</label>
                                            <input
                                                class="form-control form-shadow phone-mask"
                                                placeholder="Телефон"
                                                name="phone"
                                                value=""
                                                id="phone"
                                                data-validator-required=""
                                                data-validator="phone">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group small">
                                            <label for="blogTitle">Сумма</label>
                                            <input
                                                type="number"
                                                class="form-control form-shadow"
                                                placeholder="Сумма"
                                                name="sum"
                                                id="sum"
                                                data-validator-required=""
                                                value=""
                                                data-validator="sum">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <button type="button" class="btn btn-primary">Создать</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
