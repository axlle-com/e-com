<?php

/* @var $title string
 * @var $propertiesModel []
 * @var $properties []
 * @var $units []
 */

$string = '';
if ($propertiesModel) {
    $ids = $propertiesModel->pluck('property_id')->all();
    foreach ($propertiesModel as $propertyModel) {
        $data = [
            'propertyModel' => $propertyModel,
            'properties' => $properties,
            'units' => $units,
        ];
        $string .= view('backend.catalog.inc.property', $data);
    }
}
$ids = $ids ?? [];
?>

<div class="catalog-tabs catalog-property">
    <div class="row">
        <div class="col-md-12">
            <button
                type="button"
                class="btn btn-primary catalog-tabs-add js-catalog-property-add"
                data-js-properties-ids="<?= json_encode($ids) ?>">
                Добавить свойство
            </button>
        </div>
    </div>
    <div class="row catalog-property-block">
        <?= $string ?>
    </div>
</div>
