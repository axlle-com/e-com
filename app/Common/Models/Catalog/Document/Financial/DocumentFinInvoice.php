<?php

namespace App\Common\Models\Catalog\Document\Financial;

use App\Common\Components\Bank\Alfa;
use App\Common\Components\Delivery\Cdek;
use App\Common\Components\Mail\NotifyAdmin;
use App\Common\Components\Mail\NotifyOrder;
use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\CatalogCoupon;
use App\Common\Models\Catalog\CatalogDeliveryStatus;
use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogPaymentStatus;
use App\Common\Models\Catalog\Document\Main\DocumentBase;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\FinTransactionType;
use App\Common\Models\User\Counterparty;
use App\Common\Models\User\UserWeb;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * This is the model class for table "{{%ax_document_fin_invoice}}".
 *
 * @property int $id
 * @property string $uuid
 * @property int $counterparty_id
 * @property int $payment_order_id
 * @property int|null $catalog_payment_status_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Counterparty|null $counterparty
 * @property DocumentFinInvoiceContent[] $contents
 */
class DocumentFinInvoice extends DocumentBase
{
    public static array $fields = [
        'counterparty',
        'payment',
    ];
    private static ?self $_self = null;
    public string $paymentUrl = '';
    public array $paymentData = [];
    public float $amount = 0.0;
    public bool $isNew = false;
    public bool $isCreateDocument = false;
    protected $table = 'ax_document_fin_invoice';
    protected $fillable = [
        'id',
        'uuid',
        'counterparty_id',
        'catalog_payment_type_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'id' => 'integer',
        'counterparty_id' => 'integer',
        'uuid' => 'string',
        'catalog_payment_type_id' => 'integer',
        'status' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    public static function rules(string $type = 'create'): array
    {
        return [
                'create_fast' => [
                    'id' => 'nullable|integer',
                    'user.phone' => 'required|string',
                    'order.price' => 'required|integer',
                ],
                'create' => [
                    'id' => 'nullable|integer',
                    'user.first_name' => 'required|string',
                    'user.last_name' => 'required|string',
                    'user.phone' => 'required|string',
                    'order.catalog_payment_type_id' => 'required|integer',
                    'order.catalog_delivery_type_id' => 'required|integer',
                ],
                'posting' => [
                    'id' => 'required|integer',
                    'catalog_payment_type_id' => 'required|integer',
                    'catalog_delivery_type_id' => 'required|integer',
                    'catalog_sale_document_id' => 'required|integer',
                    'catalog_reserve_document_id' => 'required|integer',
                    'payment_order_id' => 'required|integer',
                ],
            ][$type] ?? [];
    }

    public function checkPay(): bool
    {
        $alfa = (new Alfa())
            ->setMethod('/getOrderStatus.do')
            ->setBody(['orderId' => $this->payment_order_id])
            ->send();
        if ($alfa->getErrors()) {
            return false;
        }
        $this->paymentData = $alfa->getData();
        return $this->paymentData['OrderStatus'] === 2 && $this->status === self::STATUS_POST;
    }

    public function pay(): static
    {
        $pay = (new Alfa())
            ->setMethod('/register.do')
            ->setBody(['amount' => ($this->amount) * 100, 'orderNumber' => $this->uuid])
            ->send();
        if ($pay->getErrors()) {
            return $this->setErrors($pay->getErrors());
        }
        $data = $pay->getData();
        if (empty($data['orderId']) || empty($data['formUrl'])) {
            return $this->setErrors(_Errors::error($pay::DEFAULT_MESSAGE_ERROR, $this));
        }
        $this->payment_order_id = $data['orderId'];
        $this->status = static::STATUS_POST;
        $this->paymentUrl = $data['formUrl'];
        return $this;
    }

    public function notifyAdmin(string $message): self
    {
        try {
            Mail::to(config('app.admin_email'))->send(new NotifyAdmin($message));
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        return $this;
    }

    public function notifySms(): self
    {
        try {

        } catch (Exception $exception) {

        }
        return $this;
    }

    public function posting(bool $transaction = true): static
    {
        DB::beginTransaction();
        if ($this->getErrors()) {
            return $this;
        }
        $this->status = self::STATUS_POST;
        if (($contents = $this->contents) && count($contents)) {
            foreach ($contents as $content) {
                $this->amount += ($content->price * $content->quantity);
                if ($error = $content->posting()->getErrors()) { # TODO: посмотреть на количество запросов
                    $this->setErrors($error);
                }
            }
        }
        if ($errors = $this->getErrors()) {
            DB::rollBack();
            return $this->setErrors($errors);
        }
        $this->pay();
        unset($this->contents);
        if ($this->getErrors() || $this->safe()->getErrors()) {
            DB::rollBack();
        } else {
            DB::commit();
        }
        return $this;
    }

    public function counterparty(): BelongsTo
    {
        return $this->BelongsTo(Counterparty::class, 'counterparty_id', 'id');
    }
}
