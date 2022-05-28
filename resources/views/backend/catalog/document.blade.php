<?php

/* @var $title string
 * @var $models \App\Common\Models\Catalog\Document\CatalogDocument[]
 * @var $post array
 */

use App\Common\Models\Catalog\Document\CatalogDocument;use App\Common\Models\Catalog\Document\CatalogDocumentSubject;use App\Common\Models\FinTransactionType;use App\Common\Models\User\UserWeb;

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
                    <a class="btn btn-light has-icon" href="/admin/catalog/document/update">
                        <i class="material-icons mr-1">add_circle_outline</i>Новая
                    </a>
                    <a type="button" class="btn btn-light has-icon" href="/admin/catalog/document">
                        <i class="material-icons mr-1">refresh</i>Обновить
                    </a>
                    <button type="button" class="btn btn-light has-icon">
                        <i class="mr-1" data-feather="paperclip"></i>Export
                    </button>
                    <a class="btn btn-light has-icon">Снять с резерва</a>
                </div>
                <div class="table-responsive">
                    <form id="producer-form-filter"></form>
                    <table
                        class="table table-bordered table-sm has-checkAll mb-0 sortable swap"
                        data-bulk-target="#bulk-dropdown"
                        data-checked-class="table-warning">
                        <caption class="p-0 text-right"><small>Показано 1 to 5 из 57 строк</small></caption>
                        <thead class="thead-primary">
                        <tr class="column-filter">
                            <th colspan="2"></th>
                            <th>
                                <label class="input-clearable input-icon input-icon-sm input-icon-right">
                                    <input
                                        form="producer-form-filter"
                                        type="text"
                                        value="<?= !empty($post['id']) ? $post['id'] : '' ?>"
                                        name="id"
                                        class="form-control form-control-sm border-primary"
                                        placeholder="Номер">
                                    <i data-toggle="clear" class="material-icons">clear</i>
                                </label>
                            </th>
                            <th>
                                <label class="input-clearable input-icon input-icon-sm input-icon-right border-primary">
                                    <select
                                        form="producer-form-filter"
                                        class="form-control select2"
                                        data-allow-clear="true"
                                        data-placeholder="Классификация"
                                        data-select2-search="true"
                                        name="document_subject">
                                        <option></option>
                                        <?php foreach (CatalogDocumentSubject::forSelect() as $item){ ?>
                                        <option
                                            value="<?= $item['id'] ?>" <?= (!empty($post['document_subject']) && $post['document_subject'] == $item['id']) ? 'selected' : '' ?>><?=  $item['title'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </th>
                            <th>
                                <label class="input-clearable input-icon input-icon-sm input-icon-right border-primary">
                                    <select
                                        form="producer-form-filter"
                                        class="form-control select2"
                                        data-allow-clear="true"
                                        data-placeholder="Ответственный"
                                        data-select2-search="true"
                                        name="user">
                                        <option></option>
                                        <?php foreach (UserWeb::getAllEmployees() as $item){ ?>
                                        <option
                                            value="<?= $item['id'] ?>" <?= (!empty($post['user']) && $post['user'] == $item['id']) ? 'selected' : '' ?>><?=  $item['last_name'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </th>
                            <th>
                                <label class="input-clearable input-icon input-icon-sm input-icon-right border-primary">
                                    <select
                                        form="producer-form-filter"
                                        class="form-control select2"
                                        data-allow-clear="true"
                                        data-placeholder="Тип"
                                        data-select2-search="true"
                                        name="type">
                                        <option></option>
                                        <?php foreach (FinTransactionType::forSelect() as $item){ ?>
                                        <option
                                            value="<?= $item['id'] ?>" <?= (!empty($post['type']) && $post['type'] == $item['id']) ? 'selected' : '' ?>><?=  $item['title'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </th>
                            <th>
                                <label class="input-clearable input-icon input-icon-sm input-icon-right border-primary">
                                    <select
                                        form="producer-form-filter"
                                        class="form-control select2"
                                        data-allow-clear="true"
                                        data-placeholder="Статус"
                                        data-select2-search="true"
                                        name="status">
                                        <option></option>
                                        <?php foreach (CatalogDocument::$statuses as $key => $item){ ?>
                                        <option
                                            value="<?= $key ?>" <?= (!empty($post['status']) && $post['status'] == $key) ? 'selected' : '' ?>><?= $item ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </th>
                            <th>
                                <label class="input-clearable input-icon input-icon-sm input-icon-right">
                                    <input
                                        form="producer-form-filter"
                                        type="text"
                                        name="date"
                                        value="<?= !empty($post['date']) ? $post['date'] : '' ?>"
                                        class="form-control form-control-sm border-primary date-range-picker flatpickr-input"
                                        placeholder="Дата создания"
                                        readonly="readonly">
                                    <i data-toggle="clear" class="material-icons">clear</i>
                                </label>
                            </th>
                            <th>
                                <button
                                    class="btn btn-sm btn-outline-primary btn-block has-icon js-producer-filter-button">
                                    <i class="material-icons">search</i>
                                </button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">
                                <div class="custom-control custom-control-nolabel custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <label class="custom-control-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th scope="col" class="text-center">Детали</th>
                            <th scope="col" class="width-7"><a href="javascript:void(0)" class="sorting asc">ID</a></th>
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Классификация</a></th>
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Ответственный</a></th>
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Тип</a></th>
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Статус</a></th>
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Дата создания</a></th>
                            <th scope="col" class="text-center">Действие</th>
                        </tr>
                        </thead>
                        <?php if(!empty($models)){ ?>
                        <?php foreach ($models as $item){ ?>
                        <tbody class="sort-handle">
                        <tr class="js-producer-table" data-js-product-id="<?= $item->id ?>">
                            <td>
                                <div class="custom-control custom-control-nolabel custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-<?= $item->id ?>">
                                    <label for="checkbox-<?= $item->id ?>" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="#detail-<?= $item->id ?>"
                                   class="detail-toggle text-secondary"
                                   data-toggle="collapse"
                                   role="button"
                                   aria-expanded="false"
                                   aria-controls="detail-<?= $item->id ?>">
                                </a>
                            </td>
                            <td><?= $item->id ?></td>
                            <td><?= $item->subject_title ?></td>
                            <td><?= $item->user_last_name ?></td>
                            <td><?= $item->fin_title ?></td>
                            <td><?= CatalogDocument::$statuses[$item->status] ?? '' ?></td>
                            <td><?= date('d.m.Y H:i', $item->created_at) ?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="/admin/catalog/document/update/<?= $item->id ?>" class="btn btn-link btn-icon bigger-130 text-success">
                                        <i data-feather="<?= $item->status === CatalogDocument::STATUS_POST ? 'eye' : 'edit'?>"></i>
                                    </a>
                                    <a href="/admin/catalog/document/print/<?= $item->id ?>"
                                       class="btn btn-link btn-icon bigger-130 text-info" target="_blank">
                                        <i data-feather="printer"></i>
                                    </a>
                                    <?php if($item->status !== CatalogDocument::STATUS_POST){ ?>
                                        <a href="/admin/catalog/document/delete/<?= $item->id ?>"
                                           class="btn btn-link btn-icon bigger-130 text-danger"
                                           data-js-document-table-id="<?= $item->id ?>">
                                            <i data-feather="trash"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <tr class="detail-row collapse remove-handle" id="detail-<?= $item->id ?>">
                            <td colspan="10">
                                <ul class="data-detail ml-5">
                                    <?php if($contents = $item->contents){ ?>
                                    <?php $cnt = 1; ?>
                                    <?php foreach ($contents as $content){ ?>
                                    <li>
                                        <span class="number"><?= $cnt ?>.</span>
                                        <span class="title">Название: </span><span
                                            class="description"><?= $content->product_title ?></span>
                                        <span class="title">Количество: </span><span
                                            class="description"><?= $content->quantity ?></span>
                                        <span class="title">Цена: </span><span
                                            class="description"><?= $content->price ?></span>
                                        <span class="title">Склад: </span><span
                                            class="description"><?= $content->storage_title ?></span>
                                    </li>
                                    <?php $cnt++; ?>
                                    <?php } ?>
                                    <?php } ?>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                        <?php } ?>
                        <?php } ?>
                    </table>
                </div>
                <div class="d-flex align-items-center flex-column flex-sm-row">
                    <div class="dropdown dropup bulk-dropdown align-self-start mr-2 mt-1 mt-sm-0" id="bulk-dropdown"
                         hidden>
                        <button
                            class="btn btn-light btn-sm dropdown-toggle"
                            type="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <span class="checked-counter"></span>
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item has-icon" type="button">
                                <i class="mr-2" data-feather="copy"></i>Копировать
                            </button>
                            <button class="dropdown-item has-icon" type="button">
                                <i class="mr-2" data-feather="archive"></i>В архив
                            </button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item has-icon text-danger" type="button">
                                <i class="mr-2" data-feather="trash"></i>Удалить
                            </button>
                        </div>
                    </div>
                    <!-- Show entries -->
                    {{--                    <form class="form-inline mt-1 mt-sm-0">--}}
                    {{--                        Show--}}
                    {{--                        <select class="custom-select custom-select-sm w-auto mx-1">--}}
                    {{--                            <option value="5">5</option>--}}
                    {{--                            <option value="10">10</option>--}}
                    {{--                            <option value="20">20</option>--}}
                    {{--                            <option value="50">50</option>--}}
                    {{--                        </select>--}}
                    {{--                        entries--}}
                    {{--                    </form>--}}
                    <?= $models->links('backend.pagination.default') ?>
                </div>
            </div>
        </div>
    </div>
@endsection
