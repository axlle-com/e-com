<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\User\User;
use App\Common\Models\Wallet\Currency;

/**
 * This is the model class for table "ax_catalog_basket".
 *
 * @property int $id
 * @property int $user_id
 * @property int $catalog_product_id
 * @property int|null $catalog_document_id
 * @property int|null $currency_id
 * @property int|null $ips_id
 * @property int|null $quantity
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property string|null $alias
 * @property string|null $title
 * @property string|null $price
 *
 * @property CatalogDocument $catalogDocument
 * @property CatalogProduct $catalogProduct
 * @property Currency $currency
 * @property Ips $ips
 * @property User $user
 */
class CatalogBasket extends BaseModel
{
    public const STATUS_WAIT = 0;

    protected $table = 'ax_catalog_basket';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'catalog_order_id' => 'Catalog Order ID',
            'currency_id' => 'Currency ID',
            'ips_id' => 'Ips ID',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getCatalogDocument()
    {
        return $this->hasOne(CatalogDocument::class, ['id' => 'catalog_document_id']);
    }

    public function getCatalogProduct()
    {
        return $this->hasOne(CatalogProduct::class, ['id' => 'catalog_product_id']);
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

    public static function createOrUpdate(array $post): self
    {
        /* @var $model self */
        if (empty($post['basket_id']) && !$model = self::query()->find($post['basket_id'])) {
            $model = new self();
        }
        $model->user_id = $post['user_id'];
        $model->catalog_product_id = $post['catalog_product_id'];
        $model->catalog_document_id = $post['catalog_document_id'] ?? null;
        $model->currency_id = $post['currency_id'];
        $model->ips_id = $post['ips_id'];
        $model->status = $post['status'];
        $model->quantity = 1;
        return $model->safe();
    }

    public static function existSession(int $product_id): bool
    {
        return ($ids = session('basket', [])) && array_key_exists($product_id, $ids);
    }

    public static function deleteSession(int $product_id): void
    {
        $ids = session('basket', []);
        if (array_key_exists($product_id, $ids)) {
            unset($ids[$product_id]);
        }
        session(['basket' => $ids]);
    }

    public static function createSession(int $product_id): void
    {
        /* @var $product CatalogProduct */
        if ($product = CatalogProduct::query()->find($product_id)) {
            $ids = session('basket', []);
            $ids[$product->id] = [
                'alias' => $product->alias,
                'title' => $product->title_short ?? $product->title,
                'price' => $product->price,
            ];
            session(['basket' => $ids]);
        }
    }

    public static function clearUserBasket(int $user_id): void
    {
        $basket = self::query()
            ->where('catalog_document_id', null)
            ->where('user_id', $user_id)
            ->get();
        if (count($basket)) {
            foreach ($basket as $item) {
                $item->delete();
            }
        }
    }

    public static function toggleType(int $user_id): self
    {
        /* @var $products CatalogProduct[] */
        $inst = [];
        $collection = new self();
        if ($ids = session('basket', [])) {
            self::clearUserBasket($user_id);
            $products = CatalogProduct::query()->whereIn('id', array_keys($ids))->get();
            if (count($products)) {
                foreach ($products as $product) {
                    $data = [
                        'user_id' => $user_id,
                        'catalog_product_id' => $product->id,
                    ];
                    $basket = static::createOrUpdate($data);
                    if ($err = $basket->getErrors()) {
                        $collection->setErrors(['basket' => $err]);
                        $inst[] = $basket;
                    }
                }
            }
        }
        session(['basket' => []]);
        return $collection->setCollection($inst);
    }

    public static function getBasket(int $user_id = null): array
    {
        /* @var $basket self[] */
        $array = [];
        if ($user_id) {
            $basket = self::filter()
                ->where('user_id', $user_id)
                ->where('catalog_document_id', null)
                ->get();
            if (count($basket)) {
                foreach ($basket as $item) {
                    $array[$item->catalog_product_id]['alias'] = $item->alias;
                    $array[$item->catalog_product_id]['title'] = $item->title;
                    $array[$item->catalog_product_id]['price'] = $item->price;
                }
            }
        } else {
            $array = session('basket', []);
        }
        return $array;
    }
}
