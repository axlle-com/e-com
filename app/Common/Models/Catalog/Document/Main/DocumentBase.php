<?php

namespace App\Common\Models\Catalog\Document\Main;

use Exception;
use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Common\Models\Catalog\Document\DocumentSale;
use App\Common\Models\Catalog\Document\DocumentOrder;
use App\Common\Models\Catalog\Document\DocumentComing;
use App\Common\Models\Catalog\Document\DocumentWriteOff;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Catalog\Document\DocumentReservation;
use App\Common\Models\Catalog\Document\DocumentReservationCancel;
use App\Common\Models\Catalog\Document\Financial\DocumentFinInvoice;

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
    use EventSetter;

    public static string $pageIndex = 'index';
    public static string $pageUpdate = 'update';
    public static string $pageView = 'view';
    public static array $types = [
        DocumentComing::class => [
            'key' => 'coming',
            'title' => 'Поступление',
        ],
        DocumentSale::class => [
            'key' => 'sale',
            'title' => 'Продажа',
        ],
        DocumentWriteOff::class => [
            'key' => 'write_off',
            'title' => 'Списание',
        ],
        DocumentReservation::class => [
            'key' => 'reservation',
            'title' => 'Резервирование',
        ],
        DocumentReservationCancel::class => [
            'key' => 'reservation_cancel',
            'title' => 'Снятие с резерва',
        ],
        DocumentOrder::class => [
            'key' => 'order',
            'title' => 'Ордер',
        ],
        DocumentFinInvoice::class => [
            'key' => 'fin_invoice',
            'title' => 'Счет на оплату',
        ],
    ];
    public static array $fields = [];
    public ?DocumentContentBase $contentClass;
    protected $fillable = [
        'id',
        'counterparty_id',
        'fin_transaction_type_id',
        'catalog_storage_place_id',
        'currency_id',
        'status',
        'expired_at',
    ];

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

    protected function setDefaultValue(): void
    {
        $this->setFinTransactionTypeId();
        if (empty($this->catalog_storage_place_id)) {
            $this->catalog_storage_place_id = CatalogStoragePlace::query()->where('is_place', 1)->first()->id;
        }
    }

    public static function keyDocument($class): string
    {
        return Str::kebab(Str::camel(self::$types[$class]['key']));
    }

    public static function titleDocument($class): string
    {
        return self::$types[$class]['title'];
    }

    public static function createOrUpdate(array $post, bool $isEvent = true, bool $posting = false): static
    {
        if (empty($post['id']) || !$model = static::filter()->where(static::table('id'), $post['id'])->first()) {
            $model = new static();
            $model->status = $posting ? static::STATUS_NEW : static::STATUS_POST;
        }
        $model->isEvent = $isEvent;
        $model->loadModel($post);
        $model->setDocument($post['document'] ?? null);
        $model->setContents($post['contents'] ?? null);
        return $model;
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

    public static function contentTable(string $column = '')
    {
        $string = (static::class) . 'Content';
        $column = $column ? '.' . trim($column, '.') : '';
        return (new $string())->getTable($column);
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
            $content = $this->getContentClass()::createOrUpdate($value, $this->isEvent); # TODO:!!! написать возможность сразу проводить !!!
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

    public function getContentClass(): DocumentContentBase
    {
        if (empty($this->contentClass)) {
            $this->setContentClass();
        }
        return $this->contentClass;
    }

    public function setContentClass(): static
    {
        $string = (static::class) . 'Content';
        $this->contentClass = new $string();
        return $this;
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

    public function posting(bool $transaction = true): static
    {
        if ($this->getErrors()) {
            return $this;
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
                $this->setErrors(_Errors::error($self->getErrors()?->getErrors(), $this));
            }
        } else {
            $this->_posting();
        }

        return $this;
    }

    public function deleteContent(): void
    {
        if ($this->status !== static::STATUS_POST) {
            $this->getContentClass()::query()->where('document_id', $this->id)->delete();
        }
    }

    public function setFinTransactionTypeId(): static
    {
        return $this;
    }

    private function _posting(): static
    {
        if ($this->getErrors()) {
            return $this;
        }
        if (($contents = $this->contents) && count($contents)) {
            foreach ($contents as $content) {
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
}
