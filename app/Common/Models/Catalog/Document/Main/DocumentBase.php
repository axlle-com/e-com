<?php

namespace App\Common\Models\Catalog\Document\Main;

use App\Common\Models\Catalog\Document\Coming\DocumentComing;
use App\Common\Models\Catalog\Document\Financial\DocumentFinInvoice;
use App\Common\Models\Catalog\Document\Order\DocumentOrder;
use App\Common\Models\Catalog\Document\Reservation\DocumentReservation;
use App\Common\Models\Catalog\Document\ReservationCancel\DocumentReservationCancel;
use App\Common\Models\Catalog\Document\Sale\DocumentSale;
use App\Common\Models\Catalog\Document\WriteOff\DocumentWriteOff;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\BaseModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * This is the model class for storage.
 *
 * @property int $id
 * @property int $counterparty_id
 * @property string|null $document
 * @property int|null $document_id
 * @property int $fin_transaction_type_id
 * @property int $catalog_storage_place_id
 * @property int|null $currency_id
 * @property int|null $status
 *
 * @property int|null $user_first_name
 * @property int|null $user_last_name
 * @property int|null $ip
 * @property int|null $fin_name
 * @property int|null $fin_title
 *
 * @property DocumentContentBase[] $contents
 */
class DocumentBase extends BaseModel
{
    use HasHistory;

    public static string $pageIndex = 'index';
    public static string $pageUpdate = 'update';
    public static string $pageView = 'view';
    public static array $types = [
        DocumentComing::class => [
            'key' => 'coming',
            'type' => 'credit',
            'title' => 'Поступление',
        ],
        DocumentSale::class => [
            'key' => 'sale',
            'type' => 'debet',
            'title' => 'Продажа',
        ],
        DocumentWriteOff::class => [
            'key' => 'write_off',
            'type' => 'debet',
            'title' => 'Списание',
        ],
        DocumentReservation::class => [
            'key' => 'reservation',
            'type' => 'debet',
            'title' => 'Резервирование',
        ],
        DocumentReservationCancel::class => [
            'key' => 'reservation_cancel',
            'type' => 'debet',
            'title' => 'Снятие с резерва',
        ],
        DocumentOrder::class => [
            'key' => 'order',
            'type' => 'debet',
            'title' => 'Ордер',
        ],
        DocumentFinInvoice::class => [
            'key' => 'fin_invoice',
            'type' => 'debet',
            'title' => 'Счет на оплату',
        ],
    ];
    public static array $fields = [];
    public ?DocumentContentBase $contentClass;
    protected $fillable = [
        'id',
        'catalog_storage_place_id',
        'fin_transaction_type_id',
        'counterparty_id',
        'currency_id',
        'status',
    ];

    public static function keyDocument($class): string
    {
        return Str::kebab(Str::camel(self::$types[$class]['key']));
    }

    public static function titleDocument($class): string
    {
        return self::$types[$class]['title'];
    }

    public static function deleteById(array $post): bool
    {
        $model = static::className($post['model']);
        /* @var $model static */
        if ($model && $update = $model::query()
                                      ->where('id', $post['id'])
                                      ->where('status', '!=', static::STATUS_POST)
                                      ->first()) {
            return $update->delete();
        }
        return false;
    }

    protected static function boot()
    {
        parent::boot();
        static::created(static function (DocumentBase $model) {
            $model->setHistory('created');
        });
        static::updated(static function (DocumentBase $model) {
            $model->setHistory('updated');
        });
        static::deleting(static function (DocumentBase $model) {
            $model->deleteContent();
        });
        static::deleted(static function (DocumentBase $model) {
            $model->setHistory('deleted');
        });

    }

    public function deleteContent(): void
    {
        if ($this->status !== static::STATUS_POST) {
            $this->getContentClass()::query()->where('document_id', $this->id)->delete();
        }
    }

    public function getContentClass(): DocumentContentBase
    {
        if (empty($this->contentClass)) {
            $this->setContentClass();
        }
        return $this->contentClass;
    }

    public static function rules(string $type = 'create'): array
    {
        return [
            'create' => [
                'type' => 'required|string',
                'contents' => 'required|array',
                'contents.*.catalog_product_id' => 'required|integer',
                'contents.*.document_content_id' => 'nullable|integer',
                'contents.*.price' => 'nullable|numeric',
                'contents.*.quantity' => 'required|numeric|min:1',
            ],
            'posting' => [
                'id' => 'required|integer',
                'type' => 'required|string',
                'contents' => 'required|array',
                'contents.*.catalog_product_id' => 'required|integer',
                'contents.*.document_content_id' => 'required|integer',
                'contents.*.price' => 'nullable|numeric',
                'contents.*.quantity' => 'required|numeric|min:1',
            ],
        ][$type] ?? [];
    }

    protected function setDefaultValue(): static
    {
        $this->setFinTransactionTypeId();
        if (empty($this->catalog_storage_place_id)) {
            $this->catalog_storage_place_id = CatalogStoragePlace::query()->where('is_place', 1)->first()->id;
        }
        $this->status = static::STATUS_DRAFT;
        return $this;
    }

    public function setFinTransactionTypeId(): static
    {
        return $this;
    }

    public function setContentClass(): static
    {
        $string = (static::class) . 'Content';
        $this->contentClass = new $string();
        return $this;
    }

    public function setDocument(?array $data): static
    {
        if (!empty($data)) {
            if (!empty($data['model']) && !empty($data['model_id'])) {
                $this->document = $data['model'];
                $this->document_id = $data['model_id'];
            } else {
                $this->setErrors(_Errors::error(['document' => 'Не удалось распознать документ основание'], $this));
            }
        }
        return $this;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function setContents(?array $post): static
    {
        if (empty($post)) {
            return $this->setErrors(_Errors::error(['content' => 'Документ не может быть пустым'], $this));
        }
        if ($this->isDirty()) {
            $this->safe();
        }
        if ($this->getErrors()) {
            return $this;
        }
        $cont = [];
        foreach ($post as $value) {
            $value['document_id'] = $this->id;
            $content = $this->getContentClass()::createOrUpdate($value, $this->isHistory); # TODO:!!! написать возможность сразу проводить !!!
            if ($err = $content->getErrors()) {
                $cont[] = null;
                $this->setErrors($err);
            } else {
                $cont[] = $content;
            }
        }
        if (!in_array(null, $cont, true)) {
            $this->load('contents');
        } else {
            $this->setErrors(_Errors::error(['content' => 'Произошли ошибки при записи'], $this));
        }
        return $this;
    }

    public static function createOrUpdate(array $post, bool $isHistory = true, bool $posting = false): static
    {

        if (empty($post['id']) || !$model = static::filter()->where(static::table('id'), $post['id'])->first()) {
            $model = new static();
            $model->status = $posting ? static::STATUS_NEW : static::STATUS_POST;
            $model->isNew = true;
        }
        $model->isHistory = $isHistory;
        $model->setDefaultValue()->loadModel($post);
        return $model;
    }

    public function setCatalogStoragePlaceId($catalog_storage_place_id = null): static
    {
        $this->catalog_storage_place_id = $catalog_storage_place_id ?? CatalogStoragePlace::query()
                                                                                          ->where('is_place', 1)
                                                                                          ->first()->id;
        return $this;
    }

    public function setCounterpartyId($counterparty_id): static
    {
        $this->counterparty_id = $counterparty_id;
        return $this;
    }

    public function setContentsCollection(Collection $contents): static
    {
        $this->contents = $contents;
        return $this;
    }

    public function posting(bool $transaction = true): static
    {
        if ($this->getErrors()) {
            return $this;
        }
        if ($this->getDirty()) {
            $this->safe();
        }
        if ($transaction) {
            $self = $this;
            try {
                DB::transaction(static function () use ($self) {
                    if ($self->_posting()->getErrors()) {
                        throw new RuntimeException('При сохранении возникли ошибки');
                    }
                }, 3);
            } catch (Exception $exception) {
                $this->setErrors(_Errors::exception($exception, $this));
            }
        } else {
            $this->_posting();
        }
        return $this;
    }

    private function _posting(): static
    {
        if ($this->getErrors()) {
            return $this;
        }
        if (($contents = $this->contents()->get()) && count($contents)) {
            foreach ($contents as $content) {
                /** @var DocumentContentBase $content */
                if ($error = $content->posting()->getErrors()) {
                    $this->setErrors($error);
                }
            }
        }
        if ($this->getErrors()) {
            return $this;
        }
        $this->status = static::STATUS_POST;
        return $this->safe('contents');
    }

    public function contents(): HasMany
    {
        return $this->hasMany($this->getContentClass()::class, 'document_id', 'id')
                    ->select([
                        static::contentTable('*'),
                        'product.title as product_title',
                    ])
                    ->leftJoin('ax_catalog_product as product', 'product.id', '=', static::contentTable('catalog_product_id'))
                    ->orderBy(static::contentTable('created_at'));
    }

    public static function contentTable(string $column = '')
    {
        $string = (static::class) . 'Content';
        $column = $column ? '.' . trim($column, '.') : '';
        return (new $string())->getTable($column);
    }
}
