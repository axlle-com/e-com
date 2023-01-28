<?php

use App\Common\Models\Catalog\Document\CatalogDocument;


/* @var $model CatalogDocument
 * @var
 */

$contents = $model->contents ?? [];
$view = '';
foreach ($contents as $content) {
    $view .= view($backendTemplate.'.document.inc.document_content', ['model' => $content, 'copy' => true])->render();
}
echo $view;
?>


