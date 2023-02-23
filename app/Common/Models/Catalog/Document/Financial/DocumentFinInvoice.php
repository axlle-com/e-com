<?php

namespace App\Common\Models\Catalog\Document\Financial;

use App\Common\Components\Bank\Alfa;
use App\Common\Components\Mail\NotifyAdmin;
use App\Common\Components\Sms\SMSRU;
use App\Common\Models\Catalog\CatalogPaymentStatus;
use App\Common\Models\Catalog\Document\DocumentBase;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\FinTransactionType;
use App\Common\Models\User\Counterparty;
use App\Common\Models\User\User;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RuntimeException;
use stdClass;

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
    public static string $pageIndex = 'index_fin_invoice';
    public static string $pageUpdate = 'update_fin_invoice';

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

    protected function setDefaultValue(): static
    {
        $this->setFinTransactionTypeId();
        $this->uuid = Str::uuid();
        return $this;
    }

    public function setFinTransactionTypeId(): static
    {
        $this->fin_transaction_type_id = FinTransactionType::credit()->id ?? null;
        return $this;
    }

    public static function createFast(array $post): static
    {
        $self = new static();
        try {
            DB::transaction(static function() use ($self, $post) {
                $user = User::createEmpty($post);
                if($user->getErrors()) {
                    throw new RuntimeException($user->message);
                }
                $counterparty = Counterparty::getCounterparty($user->id);
                $post['counterparty_id'] = $counterparty->id;
                $post['contents'][] = [
                    'catalog_product_id' => null,
                    'quantity' => 1,
                    'price' => $post['sum'],
                ];
                unset($post['sum'], $post['phone']);
                $item = self::createOrUpdate($post, true, true);
                if($item->getErrors()) {
                    throw new RuntimeException($item->message);
                }
                if(count($item->contents)) {
                    foreach($item->contents as $content) {
                        $item->amount += $content->price * $content->quantity;
                    }
                }
                $item->pay()->safe();
                if($item->getErrors()) {
                    throw new RuntimeException($item->message);
                }
                $data = new stdClass();
                $data->to = '+7' . _clear_phone($user->phone);
                $data->msg = 'Ссылка для оплаты заказа c fursie:  ' . $item->paymentUrl;
                $sms = (new SMSRU())->sendOne($data);
                if($sms->status !== "OK") {
                    throw new RuntimeException('Ошибка отправки смс');
                }
                if($self->getErrors()) {
                    throw new RuntimeException($self->message);
                }
            });
        } catch(Exception $exception) {
            $self->setErrors(_Errors::error($exception->getMessage(), $self));
        }
        return $self;
    }

    public function pay(): static
    {
        $pay = Alfa::payInvoice($this->amount, $this->uuid);
        if($pay->getErrors()) {
            return $this->setErrors($pay->getErrors());
        }
        $data = $pay->getData();
        if(empty($data['orderId']) || empty($data['formUrl'])) {
            return $this->setErrors(_Errors::error($pay::DEFAULT_MESSAGE_ERROR, $this));
        }
        $this->payment_order_id = $data['orderId'];
        $this->status = static::STATUS_POST;
        $this->paymentUrl = $data['formUrl'];
        return $this;
    }

    public function checkPay(): bool
    {
        $alfa = Alfa::checkPayInvoice($this->payment_order_id);
        if($alfa->getErrors()) {
            return false;
        }
        $this->paymentData = $alfa->getData();
        if($this->paymentData['OrderStatus'] === 2 && $this->status === self::STATUS_POST) {
            $this->catalog_payment_status_id = CatalogPaymentStatus::query()
                ->where('key', 'paid')
                ->first()->id ?? $this->catalog_payment_status_id;
        }
        return !$this->safe()->getErrors();
    }

    public function notifyAdmin(string $message): self
    {
        try {
            Mail::to(config('app.admin_email'))->send(new NotifyAdmin($message));
        } catch(Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        return $this;
    }

    public function notifySms(): self
    {
        try {

        } catch(Exception $exception) {

        }
        return $this;
    }

    public function counterparty(): BelongsTo
    {
        return $this->BelongsTo(Counterparty::class, 'counterparty_id', 'id');
    }
}
