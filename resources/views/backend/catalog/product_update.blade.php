<?php

/* @var $title string
 * @var $breadcrumb string
 * @var $model CatalogProperty
 */

use App\Common\Models\Catalog\Property\CatalogProperty;

$title = $title ?? 'Заголовок';
?>
@extends('backend.layout',['title' => $title])
@section('content')
    <div class="main-body a-property js-image">
        <?= $breadcrumb ?>
        <h5><?= $title ?></h5>
        <div>
            <form id="global-form" action="/admin/catalog/ajax/save-property">
                <input type="hidden" name="id" value="<?= $model->id ?? null?>">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="list-with-gap mb-2">
                                    <button type="button" class="btn btn-success js-user-save-button">Сохранить
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
                                                        name="title"
                                                        id="title"
                                                        value="<?= $model->title ?>"
                                                        data-validator="title">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="catalog_property_type_id">Тип</label>
                                                    <input
                                                        class="form-control form-shadow"
                                                        placeholder="Тип"
                                                        name="catalog_property_type_id"
                                                        id="catalog_property_type_id"
                                                        value="<?= $model->catalog_property_type_id ?>"
                                                        data-validator="catalog_property_type_id">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="catalog_property_unit_id">Единицы</label>
                                                    <input
                                                        class="form-control form-shadow"
                                                        placeholder="Единицы"
                                                        name="catalog_property_unit_id"
                                                        id="catalog_property_unit_id"
                                                        value="<?= $model->catalog_property_unit_id ?>"
                                                        data-validator="catalog_property_unit_id">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group small">
                                                    <label for="sort">Сортировка</label>
                                                    <input
                                                        class="form-control form-shadow"
                                                        placeholder="E-mail"
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
