<?php

use App\Common\Models\Catalog\Document\Main\DocumentBase;use App\Common\Models\Catalog\Document\Main\DocumentContentBase;use App\Common\Models\Main\Status;

/* @var $title string
 * @var $keyDocument string
 * @var $breadcrumb string
 * @var $model DocumentBase
 * @var $content DocumentContentBase
 */

$title = $title ?? 'Заголовок';

$contents = $model->contents ?? [];
if (!empty($model->counterparty_id)) {
    $counterparty = '<li class="list-group-item"><strong>Контрагент: </strong>
                        <span class="text-secondary">' . ($model->counterparty_name ?? $model->individual_name) . '</span>
                    </li>';
}
if (!empty($model->storage_place_title)) {
    $storage = '<li class="list-group-item"><strong>Склад: </strong>
                        <span class="text-secondary">' . $model->storage_place_title . '</span>
                    </li>';
}

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
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="list-with-gap mb-2">
                                            <a type="button"
                                               class="btn btn-secondary"
                                               href="/admin/catalog/document/<?= $keyDocument ?>">Выйти</a>
                                            <a type="button"
                                               class="btn btn-light"
                                               href="/admin/document/print/<?= $model->id ?>"
                                               target="_blank">Печать</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <ul class="list-group list-group-sm list-group-example">
                                                    <li class="list-group-item"><strong>Классификация: </strong>
                                                        <span class="text-secondary"><?= DocumentBase::titleDocument($model::class) ?></span>
                                                    </li>
                                                    <li class="list-group-item"><strong>Тип: </strong>
                                                        <span class="text-secondary"><?= $model->fin_title ?> [<?= $model->fin_name ?>] </span>
                                                    </li>
                                                    <li class="list-group-item"><strong>Статус: </strong>
                                                        <span class="text-secondary"><?= Status::STATUSES[$model->status] ?></span>
                                                    </li>
                                                    <?= $counterparty ?? '' ?>
                                                </ul>
                                            </div>
                                            <div class="col-sm-6">
                                                <ul class="list-group list-group-sm list-group-example">
                                                    <?= $storage ?? '' ?>
                                                    <li class="list-group-item"><strong>IP адрес: </strong>
                                                        <span class="text-secondary"><?= $model->ip ?></span>
                                                    </li>
                                                    <li class="list-group-item"><strong>Ответственный: </strong>
                                                        <span class="text-secondary"><?= $model->user_last_name ?></span>
                                                    </li>
                                                    <li class="list-group-item"><strong>Дата создания: </strong>
                                                        <span class="text-secondary"><?= _unix_to_string_moscow($model->created_at) ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php if(count($contents)){ ?>
                                        <table class="table table-bordered table-sm has-checkAll mb-0">
                                            <thead class="thead-primary">
                                            <tr>
                                                <th scope="col" class="width-7">№</th>
                                                <th scope="col">Продукт</th>
                                                <th scope="col">Цена</th>
                                                <th scope="col">Количество</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($contents as $content){ ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $content->product_title ?></td>
                                                <td><?= $content->price ?></td>
                                                <td><?= $content->quantity ?></td>
                                                <?php $i++; ?>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
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