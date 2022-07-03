<?php

use App\Common\Models\Catalog\Product\CatalogProduct;


/* @var $models CatalogProduct
 * @var
 */

$view = '';
foreach ($models as $model) {
    $view .= view('backend.document.inc.document_product', ['model' => $model, 'type' => true])->render();
}
echo $view;
?>


