<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogPaymentType;
use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\User;
use App\Common\Models\Wallet\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "{{%catalog_document}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $catalog_document_subject_id
 * @property int|null $catalog_document_id
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
//    public string $user_first_name = '';
//    public string $user_last_name = '';
//    public string $ip = '';
//    public string $subject_title = '';
//    public string $subject_name = '';
//    public string $fin_name = '';
//    public string $fin_title = '';

    public const STATUS_POST = 1;
    public const STATUS_NEW = 2;
    public const STATUS_DRAFT = 3;
    public static array $statuses = [
        self::STATUS_POST => 'Проведен',
        self::STATUS_NEW => 'Новый',
        self::STATUS_DRAFT => 'Черновик',
    ];
    public static array $type = [
        'debit' => 'Расход',
        'credit' => 'Приход',
    ];
    public ?CatalogDocumentSubject $subject;
    protected $table = 'ax_catalog_document';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public static function boot()
    {
        self::creating(static function ($model) {
        });
        self::created(static function ($model) {
        });
        self::updating(static function ($model) {
        });
        self::updated(static function ($model) {
        });
        self::deleting(static function ($model) {
            /* @var $model self */
        });
        self::deleted(static function ($model) {
        });
        parent::boot();
    }

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
                    'id' => 'nullable|integer',
                    'catalog_document_subject_id' => 'required|integer',
                    'content' => 'required|array',
                    'content.*.catalog_product_id' => 'required|integer',
                    'content.*.price_in' => 'nullable|numeric',
                    'content.*.price_out' => 'nullable|numeric',
                    'content.*.quantity' => 'required|numeric|min:1',
                ],
                'posting' => [
                    'id' => 'required|integer',
                    'catalog_document_subject_id' => 'required|integer',
                    'content' => 'required|array',
                    'content.*.catalog_product_id' => 'required|integer',
                    'content.*.price_in' => 'nullable|numeric',
                    'content.*.price_out' => 'nullable|numeric',
                    'content.*.quantity' => 'required|numeric|min:1',
                ],
            ][$type] ?? [];
    }

    public static function getTypeRule(): string
    {
        $rule = 'in:';
        foreach (self::$type as $key => $item) {
            $rule .= $key . ',';
        }
        return trim($rule, ',');
    }

    public function getSubject()
    {
        return CatalogDocumentSubject::query()
            ->select([
                'ax_catalog_document_subject.*',
                't.id as type_id',
                't.name as type_name',
            ])
            ->join('ax_fin_transaction_type as t', 't.id', '=', 'ax_catalog_document_subject.fin_transaction_type_id')
            ->where('ax_catalog_document_subject.id', $this->catalog_document_subject_id)
            ->first();
    }

    public static function createOrUpdate(array $post): self
    {
        if (empty($post['id']) || !$model = self::filter()->where(self::table('id'), $post['id'])
                ->first()) {
            $model = new self();
            $model->status = self::STATUS_NEW;
        }
        $model->catalog_document_subject_id = $post['catalog_document_subject_id'];
        $model->catalog_document_id = $post['catalog_document_id'] ?? null;
        $model->subject = $model->getSubject();
        $model->user_id = $post['user_id'];
        $model->ips_id = Ips::createOrUpdate($post)->id;
        if ($model->safe()->getErrors()) {
            return $model;
        }
        if (!empty($post['content'])) {
            if ($model->setContent($post['content'])) {
                return $model->load('contents');# TODO: remake
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
            }else{
                $cont[] = $content;
            }
        }
        if (in_array(null, $cont, true)) {
            return false;
        }
        return true;
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(CatalogDocumentSubject::class, 'catalog_document_subject_id', 'id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(CatalogDocumentContent::class, 'catalog_document_id', 'id')
            ->select([
                CatalogDocumentContent::table('*'),
                'pr.title as product_title',
                'st.in_stock as in_stock',
                'st.in_reserve as in_reserve',
                'st.reserve_expired_at as reserve_expired_at',
                'pl.title as storage_title',
            ])
            ->join('ax_catalog_product as pr', 'pr.id', '=', CatalogDocumentContent::table('catalog_product_id'))
            ->leftJoin('ax_catalog_storage as st', 'st.catalog_product_id', '=', 'pr.id')
            ->leftJoin('ax_catalog_storage_place as pl', 'pl.id', '=', 'st.catalog_storage_place_id')
            ->orderBy(CatalogDocumentContent::table('created_at'), 'asc');
    }

    public function posting(): self
    {
        DB::beginTransaction();
        $errors = [];
        if ($this->getErrors()) {
            return $this;
        }
        if (($contents = $this->contents) && count($contents)) {
            foreach ($contents as $content) {
                $content->incoming_document_id = $this->catalog_document_id;
                if ($error = $content->posting($this->subject)->getErrors()) {
                    $errors[] = true;
                    $this->setErrors($error);
                }
            }
        }
        if ($errors) {
            DB::rollBack();
            return $this;
        }
        $this->status = self::STATUS_POST;
        if ($this->safe()->getErrors()) {
            DB::rollBack();
        } else {
            DB::commit();
        }
        return $this;
    }

    public static function deleteById(int $id)
    {
        $item = self::query()
            ->where('id', $id)
            ->where('status', '!=', self::STATUS_POST)
            ->first();
        if ($item) {
            return $item->delete();
        }
        return false;
    }
}
