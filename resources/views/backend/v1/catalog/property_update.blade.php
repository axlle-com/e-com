<?php

/** @var $title string
 * @var $breadcrumb string
 * @var $model      CatalogProperty
 */

use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyType;
use App\Common\Models\Catalog\Property\CatalogPropertyUnit;
use App\Common\Models\Setting\Setting;



$title = $title ?? 'Заголовок';
?>
@extends($layout,['title' => $title])
@section('content')
    <div class="main-body a-property js-image">
        <?= $breadcrumb ?>
        <h5><?= $title ?></h5>
        <div>
            <form id="global-form" action="/admin/catalog/ajax/save-property">
                <input type="hidden" name="property_id" value="<?= $model->id ?? null?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-with-gap mb-2">
                                    <button type="button" class="btn btn-success js-save-button">Сохранить
                                    </button>
                                    <a type="button" class="btn btn-secondary" href="/admin/catalog/property">Выйти</a>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="title">Заголовок</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="Заголовок"
                                                            name="property_title"
                                                            id="title"
                                                            value="<?= $model->title ?>"
                                                            data-validator="title">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                            type="checkbox"
                                                            class="custom-control-input"
                                                            name="is_hidden"
                                                            id="is_hidden"
                                                        <?= $model->is_hidden ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="is_hidden">
                                                        Скрытое свойство
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <?php
                                                if (count($pid = CatalogPropertyType::forSelect())){ ?>
                                                <div class="form-group small">
                                                        <?php
                                                    if ($model->catalog_property_type_id){ ?>
                                                    <input type="hidden" name="catalog_property_type_id"
                                                           value="<?= $model->catalog_property_type_id ?>">
                                                    <?php
                                                    } ?>
                                                    <label for="catalog_property_type_id">Тип</label>
                                                    <select
                                                            class="form-control select2"
                                                            data-placeholder="Тип"
                                                            data-select2-search="true"
                                                            name="catalog_property_type_id"
                                                            data-validator="catalog_property_type_id"
                                                            <?= $model->catalog_property_type_id ? 'disabled' : '' ?>>
                                                        <option></option>
                                                            <?php
                                                        foreach ($pid as $item){ ?>
                                                        <option
                                                                value="<?= $item['id'] ?>" <?= ($item['id']
                                                            == $model->catalog_property_type_id) ? 'selected'
                                                            : '' ?>><?= $item['title'] ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <?php
                                                } ?>
                                            </div>
                                            <div class="col-sm-12">
                                                <?php
                                                if (count($pid = CatalogPropertyUnit::forSelect())){ ?>
                                                <div class="form-group small">
                                                    <label for="catalog_property_type_id">Единицы</label>
                                                    <select
                                                            class="form-control select2"
                                                            data-placeholder="Единицы"
                                                            data-select2-search="true"
                                                            name="catalog_property_unit_id"
                                                            data-validator="catalog_property_unit_id">
                                                        <option></option>
                                                            <?php
                                                        foreach ($pid as $item){ ?>
                                                        <option
                                                                value="<?= $item['id'] ?>" <?= ($item['id']
                                                            == $model->catalog_property_unit_id) ? 'selected'
                                                            : '' ?>><?= $item['title'] ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <?php
                                                } ?>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="sort">Сортировка</label>
                                                    <input
                                                            type="number"
                                                            class="form-control form-shadow"
                                                            placeholder="Сортировка"
                                                            name="sort"
                                                            id="sort"
                                                            value="<?= $model->sort ?>"
                                                            data-validator="sort">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="description">Описание</label>
                                                    <input
                                                            class="form-control form-shadow"
                                                            placeholder="Описание"
                                                            name="description"
                                                            type="text"
                                                            id="description"
                                                            value="<?= $model->description ?>"
                                                            data-validator="description">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
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
