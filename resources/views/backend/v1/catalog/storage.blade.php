<?php

/** @var $title string
 * @var $models CatalogStorage[]
 * @var $post   array
 */

use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Setting\Setting;



$title = $title ?? 'Склад';

?>
@extends($layout,['title' => $title])

@section('content')
    <div class="main-body a-storage-index js-index">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style3">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
        <h5><?= $title ?></h5>
        <div class="card js-storage">
            <div class="card-body js-storage-inner">
                <section id="section7" class="">
                    <div class="btn-group btn-group-sm mb-3" role="group">
                        <a class="btn btn-light has-icon js-storage-update"
                           data-storage-update-href="/admin/catalog/ajax/storage-update"
                           href="javascript:void(0)">
                            <i class="material-icons mr-1">add_circle_outline</i>Сохранить
                        </a>
                        <a type="button" class="btn btn-light has-icon js-storage-write-off"
                           href="javascript:void(0)">
                            <i class="material-icons mr-1">refresh</i>Списать
                        </a>
                        <button type="button" class="btn btn-light has-icon">
                            <i class="mr-1" data-feather="paperclip"></i>Export
                        </button>
                    </div>
                    <div class="table-responsive">
                        <form id="storage-form"></form>
                        <table class="table table-bordered table-sm has-checkAll mb-0">
                            <thead class="thead-primary">
                            <tr>
                                <th scope="col">
                                    <div class="custom-control custom-control-nolabel custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th scope="col" class="width-7"><a href="javascript:void(0)" class="sorting asc">№</a>
                                </th>
                                <th scope="col"><a href="javascript:void(0)" class="sorting">Заголовок</a></th>
                                <th scope="col" class="text-align-end"><a href="javascript:void(0)" class="sorting">Цена
                                        закупки</a></th>
                                <th scope="col" class="text-align-end"><a href="javascript:void(0)" class="sorting">Цена
                                        продажи</a></th>
                                <th scope="col" class="text-align-end"><a href="javascript:void(0)" class="sorting">Количество</a>
                                </th>
                                <th scope="col" class="text-align-end"><a href="javascript:void(0)" class="sorting">В
                                        резерве</a></th>
                                <th scope="col"><a href="javascript:void(0)" class="sorting">Склад</a></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 1; ?>
                            <?php
                            foreach ($models as $model){ ?>
                            <tr>
                                <td>
                                    <div class="custom-control custom-control-nolabel custom-checkbox">
                                        <input
                                                type="checkbox"
                                                class="custom-control-input"
                                                id="checkbox-<?= $model->id ?>"
                                                name="product[id]"
                                        >
                                        <label for="checkbox-<?= $model->id ?>" class="custom-control-label"></label>
                                    </div>
                                </td>
                                <th scope="row"><?= $cnt ?></th>
                                <td><?= $model->product_title ?></td>
                                <td class="text-align-end"><?= _price($model->price_in) ?></td>
                                <td class="text-align-end col-price-out">
                                    <input
                                            class="border-primary js-storage-update-input"
                                            type="number"
                                            name="price"
                                            data-storage-place-id="<?= $model->catalog_storage_place_id ?>"
                                            data-product-id="<?= $model->catalog_product_id ?>"
                                            value="<?= $model->price_out ?>"
                                    >
                                </td>
                                <td class="text-align-end col-price-out">
                                    <input
                                            class="border-primary inline js-storage-update-input"
                                            type="number"
                                            name="cnt"
                                            data-storage-place-id="<?= $model->catalog_storage_place_id ?>"
                                            data-product-id="<?= $model->catalog_product_id ?>"
                                            value="0"
                                    >
                                        <?= $model->in_stock ?>
                                </td>
                                <td class="text-align-end"><?= $model->in_reserve ?></td>
                                <td class="font-number"><?= $model->storage_title ?></td>
                            </tr>
                                <?php
                                $cnt++; ?>
                                <?php
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
