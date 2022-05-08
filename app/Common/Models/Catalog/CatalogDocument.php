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
    public const STATUS_NEW = 1;
    public ?CatalogDocumentSubject $subject;

    protected $table = 'ax_catalog_document';
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

    public static function createOrUpdate(array $post): self
    {
        if (empty($post['catalog_document_id']) || !$model = self::query()->find($post['catalog_document_id'])) {
            $model = new self();
            $model->status = self::STATUS_NEW;
        }
        $model->subject = $post['subject'];
        $model->catalog_document_subject_id = $model->subject->id ?? null;
        $model->user_id = $post['user_id'];
        $model->ips_id = Ips::createOrUpdate($post)->id;
        if ($model->safe()->getErrors()) {
            return $model;
        }
        if (!empty($post['product'])) {
            if ($model->setProduct($post['product'])) {
                return $model;
            }
            return $model->setErrors(['catalog_document_content' => 'Произошли ошибки при записи']);
        }
        return $model->setErrors(['product' => 'Пустой массив']);
    }

    public function setProduct(array $post): bool
    {
        $cont = [];
        $data = [];
        foreach ($post as $value) {
            $value['catalog_document_id'] = $this->id;
            $value['type'] = $this->subject->type_name ?? null;
            $value['subject'] = $this->subject->name ?? null;
            $content = CatalogDocumentContent::createOrUpdate($value);
            if ($content->getErrors()) {
                $cont[] = null;
            } else {
                $cont[] = $content;
            }
        }
        if (in_array(null, $cont, true)) {
            return false;
        }
        return true;
    }
}
