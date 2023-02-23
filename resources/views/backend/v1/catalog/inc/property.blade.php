<?php

use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyUnit;

/** @var $models CatalogProperty[]
 * @var $property CatalogProperty
 * @var $units CatalogPropertyUnit[]
 * @var $properties CatalogProperty[]
 * @var
 */

$uuid = _uniq_id();
$property_value_id = $propertyModel->property_value_id ?? null;
$property_value_sort = $propertyModel->property_value_sort ?? null;
$property_unit_id = $propertyModel->property_unit_id ?? null;
$property_id = $propertyModel->property_id ?? null;
$property_title = $propertyModel->property_title ?? null;
$type_resource = $propertyModel->type_resource ?? null;

if(isset($properties) && count($properties)) {
    $propertiesOption = '';
    foreach($properties as $property) {
        $type = $property->type_resource ?? null;
        $propertiesOption .=
            '<option
            data-js-property-type="' . $type . '"
            data-js-property-units="' . ($property->unit->id ?? '') . '"
            value="' . $property->id . '">' . $property->title . '</option>';
    }
    $unitsOption = '';
    foreach($units as $unit) {
        $unitsOption .=
            '<option value="' . $unit->id . '" ' . ($unit->id === $property_unit_id ? 'selected' : '') . '>' . $unit->title . '</option>';
    }
}
?>
<?php if(isset($properties) && count($properties)){ ?>
<div class="col-md-12 mb-3 js-catalog-property-widget sort-handle">
    <div class="card h-100">
        <div class="card-header">
            Свойство
            <div class="btn-group btn-group-sm ml-auto" role="group">
                <button type="button" class="btn btn-light btn-icon" data-toggle="modal" data-target="#property-modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-plus">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
                <button
                    type="button"
                    data-js-property-id="<?= $property_id ?>"
                    class="btn btn-light btn-icon">
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
            <button
                type="button"
                data-js-property-value-model="<?= $type_resource ?>"
                data-js-property-value-id="<?= $property_value_id ?>"
                data-js-property-array-id=""
                class="ml-1 btn btn-sm btn-light btn-icon">
                <i class="material-icons">close</i>
            </button>
        </div>
        <div class="card-body">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Свойство</span>
                </div>
                <div class="form-group prop small">
                        <?php if($property_id){ ?>
                    <input
                        type="text"
                        value="<?= $property_title ?>"
                        class="form-control form-shadow w-100"
                        data-js-catalog-property-id="<?= $property_id ?>"
                        disabled>
                    <input type="hidden" name="property[<?= $uuid ?>][property_id]" value="<?= $property_id ?>">
                    <?php }else{ ?>
                    <select
                        class="form-control select2 js-property-type"
                        data-placeholder="Свойство"
                        data-select2-search="true"
                        data-validator-required
                        data-validator="property.<?= $uuid ?>.property_id"
                        name="property[<?= $uuid ?>][property_id]">
                        <option></option>
                            <?= $propertiesOption ?? null ?>
                    </select>
                    <div class="invalid-feedback"></div>
                    <?php } ?>
                </div>
                <div class="form-group units small">
                    <select
                        class="form-control select2 js-property-unit"
                        data-placeholder="Единицы"
                        data-allow-clear="true"
                        data-select2-search="true"
                        name="property[<?= $uuid ?>][property_unit_id]">
                        <option></option>
                            <?= $unitsOption ?? null ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group sort small">
                    <input
                        type="number"
                        value="<?= $property_value_sort ?>"
                        name="property[<?= $uuid ?>][property_value_sort]"
                        class="form-control form-shadow"
                        placeholder="Сортировка">
                </div>
                <div class="form-group value small">
                        <?php if($property_value_id){ ?>
                    <input type="hidden" name="property[<?= $uuid ?>][property_value_id]"
                           value="<?= $property_value_id ?>">
                    <?php } ?>
                    <input
                        type="text"
                        value="<?= $propertyModel->property_value ?? null ?>"
                        name="property[<?= $uuid ?>][property_value]"
                        class="form-control form-shadow js-property-value"
                        data-validator-required
                        data-validator="property.<?= $uuid ?>.property_value"
                        placeholder="Значение">
                    <input type="hidden" name="property[<?= $uuid ?>][type_resource]" value="<?= $type_resource ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

