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
                </div>
                @include('backend.document.inc.document_index', ['models' => $models])
            </div>
        </div>
    </div>
@endsection
