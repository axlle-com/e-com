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
<div class="catalog-tabs catalog-property">
    <div class="row">
        <div class="col-md-12">
            <button
                type="button"
                class="btn btn-primary catalog-tabs-add js-catalog-property-add">Добавить свойство</button>
        </div>
    </div>
    <div class="row catalog-property-block">
    </div>
</div>
