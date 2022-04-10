<?php

use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Catalog\CatalogProductWidgets;
use App\Common\Models\Catalog\CatalogProductWidgetsContent;

/* @var $title string
 * @var $tabs CatalogProductWidgetsContent[]
 * @var $widget CatalogProductWidgets
 * @var $model CatalogProduct
 */

$widget = $model->widgetTabs;
$tabs = $widget->content ?? [];

?>
<div class="catalog-property">
    <div class="row">
        <div class="col-md-12">
            <button
                type="button"
                class="btn btn-primary catalog-property-add js-catalog-property-add">Добавить свойство</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="card h-100">
                <div class="card-header">
                    Свойство
                    <div class="btn-group btn-group-sm ml-auto" role="group">
                        <button type="button" class="btn btn-light btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-plus">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-light btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-light btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-trash">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="dropdown ml-1">
                        <button class="btn btn-sm btn-light btn-icon dropdown-toggle no-caret" type="button"
                                id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">arrow_drop_down</i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2" style="">
                            <button class="dropdown-item" type="button">Action</button>
                            <button class="dropdown-item" type="button">Another action</button>
                            <button class="dropdown-item" type="button">Something else here</button>
                        </div>
                    </div>
                    <button type="button" data-action="close" class="ml-1 btn btn-sm btn-light btn-icon">
                        <i class="material-icons">close</i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Свойство</span>
                        </div>
                        <div class="form-group small">
                            <select
                                class="form-control select2"
                                data-placeholder="Свойство"
                                data-select2-search="true"
                                name="property_id"
                                data-validator="property_id">
                                <option></option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group small">
                            <input type="text" class="form-control form-shadow" placeholder="Значение">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
