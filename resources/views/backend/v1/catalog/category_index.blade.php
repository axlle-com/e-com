<?php

/** @var string $title
 * @var Collection<CatalogCategory> $models
 * @var array                       $post
 * @var string                      $breadcrumb
 */

use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Render;
use Illuminate\Database\Eloquent\Collection;
use App\Common\Models\Setting\Setting;




$title = $title ?? 'Заголовок';

?>
@extends($layout,['title' => $title])

@section('content')
    <div class="main-body blog-category js-index">
        <?= $breadcrumb ?>
        <h5><?= $title ?></h5>
        <div class="card js-producer">
            <div class="card-body js-producer-inner">
                <div class="btn-group btn-group-sm mb-3" role="group">
                    <a class="btn btn-light has-icon" href="/admin/catalog/category-update">
                        <i class="material-icons mr-1">add_circle_outline</i>Новая
                    </a>
                    <a type="button" class="btn btn-light has-icon" href="/admin/catalog/category">
                        <i class="material-icons mr-1">refresh</i>Обновить
                    </a>
                    <button type="button" class="btn btn-light has-icon">
                        <i class="mr-1" data-feather="paperclip"></i>Export
                    </button>
                </div>
                <div class="table-responsive">
                    <form id="producer-form-filter"></form>
                    <table
                            class="table table-bordered table-sm has-checkAll mb-0"
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
                                <label class="input-clearable input-icon input-icon-sm input-icon-right">
                                    <input
                                            form="producer-form-filter"
                                            name="title"
                                            value="<?= !empty($post['title']) ? $post['title'] : '' ?>"
                                            type="text"
                                            class="form-control form-control-sm border-primary"
                                            placeholder="Заголовок">
                                    <i data-toggle="clear" class="material-icons">clear</i>
                                </label>
                            </th>
                            <th>
                                <label class="input-clearable input-icon input-icon-sm input-icon-right border-primary">
                                    <select
                                            form="producer-form-filter"
                                            class="form-control select2"
                                            data-allow-clear="true"
                                            data-placeholder="Категория"
                                            data-select2-search="true"
                                            name="category">
                                        <option></option>
                                        <?php
                                        foreach (CatalogCategory::forSelect() as $item){ ?>
                                        <option
                                                value="<?= $item['id'] ?>" <?= ( ! empty($post['category'])
                                            && $post['category'] == $item['id']) ? 'selected'
                                            : '' ?>><?= $item['title'] ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                    <i data-toggle="clear" class="material-icons">clear</i>
                                </label>
                            </th>
                            <th>
                                <label class="input-clearable input-icon input-icon-sm input-icon-right border-primary">
                                    <select
                                            form="producer-form-filter"
                                            class="form-control select2"
                                            data-allow-clear="true"
                                            data-placeholder="Шаблон"
                                            data-select2-search="true"
                                            name="render">
                                        <option></option>
                                        <?php
                                        foreach (Render::forSelect() as $item){ ?>
                                        <option
                                                value="<?= $item['id'] ?>" <?= ( ! empty($post['render'])
                                            && $post['render'] == $item['id']) ? 'selected'
                                            : '' ?>><?= $item['title'] ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                    <i data-toggle="clear" class="material-icons">clear</i>
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
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Заголовок</a></th>
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Категория</a></th>
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Шаблон</a></th>
                            <th scope="col"><a href="javascript:void(0)" class="sorting">Дата создания</a></th>
                            <th scope="col" class="text-center">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ( ! empty($models)){ ?>
                            <?php
                        foreach ($models as $item){ ?>
                        <tr class="js-producer-table">
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
                            <td><?= $item->title_short ?: $item->title ?></td>
                            <td><?= $item->category_title_short ?: $item->category_title ?></td>
                            <td><?= $item->render_title ?></td>
                            <td><?= date('d.m.Y H:i', $item->created_at) ?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs" role="group">
                                    <a href="/admin/catalog/category-update/<?= $item->id ?>"
                                       class="btn btn-link btn-icon bigger-130 text-success">
                                        <i data-feather="edit"></i>
                                    </a>
                                    <a href="/admin/catalog/category-update/print/<?= $item->id ?>"
                                       class="btn btn-link btn-icon bigger-130 text-info" target="_blank">
                                        <i data-feather="printer"></i>
                                    </a>
                                    <a href="/admin/catalog/category-delete/<?= $item->id ?>"
                                       class="btn btn-link btn-icon bigger-130 text-danger"
                                       data-js-post-category-table-id="<?= $item->id ?>">
                                        <i data-feather="trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr class="detail-row collapse" id="detail-<?= $item->id ?>">
                            <td colspan="10">
                                <ul class="data-detail ml-5">
                                    <li><span>Заголовок: </span> <span><?= $item->title ?></span></li>
                                    <li><span>Описание короткое: </span> <span><?= $item->preview_description ?></span>
                                    </li>
                                    <li><span>Заголовок SEO: </span> <span><?= $item->title_seo ?></span></li>
                                    <li><span>Описание SEO: </span> <span><?= $item->description_seo ?></span></li>
                                </ul>
                            </td>
                        </tr>
                            <?php
                        } ?>
                            <?php
                        } ?>
                        </tbody>
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
                    <?= $models->links($pagination) ?>
                </div>
            </div>
        </div>
    </div>
@endsection
