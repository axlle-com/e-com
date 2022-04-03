<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%catalog_document_content}}".
 *
 * @property int $id
 * @property int $catalog_document_id
 * @property int $catalog_product_id
 *
 * @property CatalogDocument $catalogDocument
 * @property CatalogProduct $catalogProduct
 */
class CatalogDocumentContent extends BaseModel
{
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_document_id' => 'Catalog Document ID',
            'catalog_product_id' => 'Catalog Product ID',
        ];
    }

    public function getCatalogDocument()
    {
        return $this->hasOne(CatalogDocument::className(), ['id' => 'catalog_document_id']);
    }

    public function getCatalogProduct()
    {
        return $this->hasOne(CatalogProduct::className(), ['id' => 'catalog_product_id']);
    }
}
