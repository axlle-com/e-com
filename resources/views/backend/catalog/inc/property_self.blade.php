<?php

use App\Common\Models\Catalog\Property\CatalogProperty;use App\Common\Models\Catalog\Property\CatalogPropertyType;use App\Common\Models\Catalog\Property\CatalogPropertyUnit;

/**
 * @var $units CatalogPropertyUnit[]
 * @var $types CatalogPropertyType[]
 * @var $model CatalogProperty
 */

$property_id = isset($model) ? $model->id : null;
$property_title = isset($model) ? $model->title : null;
$property_type = isset($model) ? $model->catalog_property_type_id : null;
$property_type_title = isset($model) ? $model->type_title : null;
$property_unit = isset($model) ? ($model->unit->id ?? null) : null;

$option = '';
if (isset($units) && count($units)) {
    foreach ($units as $unit) {
        $cs = $unit->id === $property_unit ? 'selected' : '';
        $option .= '<option value="' . $unit->id . '" ' . $cs . '>' . $unit->title . '</option>';
    }
}
$optionTypes = '';
if (isset($types) && count($types)) {
    foreach ($types as $type) {
        $cs = $type->id === $property_type ? 'selected' : '';
        $optionTypes .= '<option value="' . $type->id . '" ' . $cs . '>' . $type->title . '</option>';
    }
}
?>

<fieldset class="form-fieldset">
    <input
        type="hidden"
        value="<?= $property_id ?>"
        name="property_id">
    <legend>Свойства</legend>
    <div class="form-row">
        <div class="form-group col-sm-12">
            <label for="property_name">Наименование</label>
            <input
                data-validator-required
                data-validator="property_title"
                type="text"
                value="<?= $property_title ?>"
                form="property-form"
                class="form-control form-shadow"
                id="property_title"
                name="property_title">
        </div>
        <?php if($option){ ?>
        <div class="form-group col-sm-12">
            <label for="property_unit_id">Единицы</label>
            <select
                class="form-control select2"
                form="property-form"
                data-placeholder="Единицы"
                data-select2-search="true"
                name="catalog_property_unit_id"
                data-validator="catalog_property_unit_id">
                <option></option>
                <?= $option ?>
            </select>
            <div class="invalid-feedback"></div>
        </div>
        <?php } ?>
        <?php if($optionTypes){ ?>
        <div class="form-group col-sm-12">
            <label for="property_unit_id">Тип</label>
            <?php if($property_id){ ?>
            <input type="text" value="<?= $property_type_title ?>" class="form-control form-shadow w-100" disabled>
            <input type="hidden" value="<?= $property_type ?>" name="catalog_property_type_id">
            <?php }else{ ?>
            <select
                class="form-control select2"
                form="property-form"
                data-validator-required
                data-placeholder="Тип"
                data-select2-search="true"
                name="catalog_property_type_id"
                data-validator="catalog_property_type_id">
                <option></option>
                <?= $optionTypes ?>
            </select>
            <div class="invalid-feedback"></div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</fieldset>




