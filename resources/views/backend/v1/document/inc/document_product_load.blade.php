<?php

use App\Common\Models\Catalog\Product\CatalogProduct;


/** @var $models CatalogProduct
 * @var $coming bool
 */

$view = '';
foreach ($models as $model) {
    $view .= view($backendTemplate.'.document.inc.document_product', [
        'model' => $model,
        'type' => true,
        'coming' => $coming
    ])->render();
}
echo $view;
?>


