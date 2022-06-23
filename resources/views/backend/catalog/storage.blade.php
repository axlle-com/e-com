<?php

/* @var $title string
 * @var $models CatalogStorage[]
 * @var $post array
 */

use App\Common\Models\Catalog\Storage\CatalogStorage;

$title = $title ?? 'Склад';

$storages = [];
foreach ($models as $model) {
    if (!isset($storages[$model->storage_title])) {
        $storages[$model->storage_title] = '';
    }
    $storages[$model->storage_title] .= '<tr>
                                                    <th scope="row">' . $model->id . '</th>
                                                    <td>' . $model->product_title . '</td>
                                                    <td>' . $model->price_out . '</td>
                                                    <td>' . $model->in_stock . '</td>
                                                    <td>' . $model->in_reserve . '</td>
                                                    <td class="font-number">' . $model->storage_title . '</td></tr>';

}
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
            <div class="card-body js-storage-inner">
                <section id="section7" class="">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm has-checkAll mb-0">
                            <thead class="thead-primary">
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Название</th>
                                <th scope="col">Цена продажи</th>
                                <th scope="col">Количество</th>
                                <th scope="col">В резерве</th>
                                <th scope="col">Склад</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($storages as $storage => $value){ ?>
                            <tr><td colspan="6"><h5><?= $storage ?></h5></td></tr>
                            <?= $value ?>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
