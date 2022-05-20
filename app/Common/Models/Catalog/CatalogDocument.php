<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\User;
use App\Common\Models\Wallet\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%catalog_document}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $catalog_document_subject_id
 * @property int|null $currency_id
 * @property int|null $ips_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property int|null $user_first_name
 * @property int|null $user_last_name
 * @property int|null $ip
 * @property int|null $subject_title
 * @property int|null $subject_name
 * @property int|null $fin_name
 * @property int|null $fin_title
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogDeliveryType $catalogDeliveryType
 * @property CatalogDocumentSubject $subject
 * @property CatalogPaymentType $catalogPaymentType
 * @property Currency $currency
 * @property Ips $ips
 * @property User $user
 * @property CatalogDocumentContent[] $contents
 */
class CatalogDocument extends BaseModel
{
    public const STATUS_POST = 1;
    public const STATUS_NEW = 2;
    public const STATUS_DRAFT = 3;
    public static array $type = [
        'debit' => 'Расход',
        'credit' => 'Приход',
    ];
    public ?CatalogDocumentSubject $subject;
    protected $table = 'ax_catalog_document';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
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
        if (!empty($post['content'])) {
            if ($model->setContent($post['content'])) {
                return $model;
            }
            return $model->setErrors(['catalog_document_content' => 'Произошли ошибки при записи']);
        }
        return $model->setErrors(['product' => 'Пустой массив']);
    }

    public function setContent(array $post): bool
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
                $this->contents->push($content);
            }
        }
        if (in_array(null, $cont, true)) {
            return false;
        }
        return true;
    }

    public function getCatalogBaskets()
    {
        return $this->hasMany(CatalogBasket::class, ['catalog_order_id' => 'id']);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(CatalogDocumentSubject::class, 'catalog_document_subject_id', 'id');
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

    public function contents(): HasMany
    {
        return $this->hasMany(CatalogDocumentContent::class, 'catalog_document_id', 'id')
            ->select([
                CatalogDocumentContent::table() . '.*',
                'pr.title as product_title',
                'st.in_stock as in_stock',
                'st.in_reserve as in_reserve',
                'st.reserve_expired_at as reserve_expired_at',
                'pl.title as storage_title',
            ])
            ->join('ax_catalog_product as pr', 'pr.id', '=', CatalogDocumentContent::table() . '.catalog_product_id')
            ->join('ax_catalog_storage as st', 'st.id', '=', CatalogDocumentContent::table() . '.catalog_storage_id')
            ->join('ax_catalog_storage_place as pl', 'pl.id', '=', 'st.catalog_storage_place_id');
    }

    public function posting(): self
    {
        $errors = [];
        if (($contents = $this->contents) && count($contents)) {
            foreach ($contents as $content) {
                if ($error = $content->posting($this->subject)->getErrors()) {
                    $errors[] = true;
                    $this->setErrors($error);
                }
            }
        }
        if ($errors) {
            return $this;
        }
        $this->status = self::STATUS_POST;
        return $this->safe();
    }
}
