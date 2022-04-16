<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\User;
use App\Common\Models\Wallet\Currency;

/**
 * This is the model class for table "{{%catalog_document}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $catalog_document_subject_id
 * @property int|null $currency_id
 * @property int|null $ips_id
 * @property int|null $catalog_delivery_type_id
 * @property int|null $catalog_payment_type_id
 * @property string $type
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogDeliveryType $catalogDeliveryType
 * @property CatalogDocumentSubject $catalogDocumentSubject
 * @property CatalogPaymentType $catalogPaymentType
 * @property Currency $currency
 * @property Ips $ips
 * @property User $user
 * @property CatalogDocumentContent[] $catalogDocumentContents
 */
class CatalogDocument extends BaseModel
{
    public static array $type = [
        'debit' => 'Расход',
        'credit' => 'Приход',
    ];

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'catalog_document_subject_id' => 'Catalog Document Subject ID',
            'currency_id' => 'Currency ID',
            'ips_id' => 'Ips ID',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogBaskets()
    {
        return $this->hasMany(CatalogBasket::class, ['catalog_order_id' => 'id']);
    }

    public function getCatalogDocumentSubject()
    {
        return $this->hasOne(CatalogDocumentSubject::class, ['id' => 'catalog_document_subject_id']);
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    public function getIps()
    {
        return $this->hasOne(Ips::class, ['id' => 'ips_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCatalogDocumentContents()
    {
        return $this->hasMany(CatalogDocumentContent::class, ['catalog_document_id' => 'id']);
    }

    public static function getTypeRule(): string
    {
        $rule = 'in:';
        foreach (self::$type as $key => $item) {
            $rule .= $key . ',';
        }
        return trim($rule, ',');
    }
}
