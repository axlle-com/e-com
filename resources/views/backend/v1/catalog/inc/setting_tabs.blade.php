<?php

/** @var $title string
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
        $string .= view($backendTemplate.'.catalog.inc.property', $data);
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
    <div class="row catalog-property-block sortable swap">
        <?= $string ?>
    </div>
    <div class="modal fade show" id="property-modal" tabindex="-1" aria-labelledby="property-modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white shadow-none">
                    <h6 class="modal-title">Свойства</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body js-property-modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success js-save-modal-button">Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Выйти</button>
                </div>
            </div>
        </div>
    </div>
</div>
