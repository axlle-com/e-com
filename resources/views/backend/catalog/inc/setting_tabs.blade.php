<?php

use App\Common\Models\Catalog\CatalogProduct;use App\Common\Models\Catalog\CatalogProductWidgets;use App\Common\Models\Catalog\CatalogProductWidgetsContent;

/* @var $title string
 * @var $tabs CatalogProductWidgetsContent[]
 * @var $widget CatalogProductWidgets
 * @var $model CatalogProduct
 * @var $propertiesModel []
 * @var $properties []
 * @var $units []
 */
?>
{{----}}

<div class="catalog-tabs catalog-property">
    <div class="row">
        <div class="col-md-12">
            <button
                type="button"
                class="btn btn-primary catalog-tabs-add js-catalog-property-add">Добавить свойство
            </button>
        </div>
    </div>
    <div class="row catalog-property-block">
        <?php
        if ($propertiesModel) {
            $ids = $propertiesModel->pluck('property_id')->all();
            foreach ($propertiesModel as $propertyModel) {
                $data = [
                    'propertyModel' => $propertyModel,
                    'properties' => $properties,
                    'units' => $units,
                    'ids' => $ids,
                ];
                echo view('backend.catalog.inc.property',$data);
            }
        }
        ?>
    </div>
</div>
