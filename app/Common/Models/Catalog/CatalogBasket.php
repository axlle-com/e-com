<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Document\DocumentOrder;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\User\User;
use App\Common\Models\Wallet\Currency;
use Illuminate\Database\Eloquent\Collection;

/**
 * This is the model class for table "ax_catalog_basket".
 *
 * @property int $id
 * @property int $user_id
 * @property int $catalog_product_id
 * @property int|null $document_order_id
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
 * @property string|null $image
 * @property int|null $is_single
 *
 * @property CatalogDocument $catalogDocument
 * @property CatalogProduct $catalogProduct
 * @property Currency $currency
 * @property Ips $ips
 * @property User $user
 */
class CatalogBasket extends BaseModel
{
    use EventSetter;

    protected $table = 'ax_catalog_basket';

    public static function rules(string $type = 'create'): array
    {
        return [
                'update' => [
                    'catalog_product_id' => 'required|integer',
                    'quantity' => 'required|integer|min:0'
                ],
                'delete' => [
                    'catalog_product_id' => 'required|integer',
                    'quantity' => 'nullable|integer|min:0'
                ],
            ][$type] ?? [];
    }

    public static function addBasket(array $post): array
    {
        /* @var $product CatalogProduct */
        if ($product = CatalogProduct::stock()->find($post['catalog_product_id'])) {
            $post['quantity'] = $product->is_single ? 1 : ($post['quantity'] ?? 1);
            if (empty($post['user_id'])) {
                $post['is_add'] = true;
                self::basketSession($post, $product);
            } else {
                /* @var $model self */
                $model = self::filter($post)->first();
                if ($model) {
                    if (!$product->is_single) {
                        $model->quantity += $post['quantity'];
                        $model->safe();
                    }
                } else {
                    self::createOrUpdate($post);
                }
            }
            $ids = self::getBasket($post['user_id'] ?? null);
        }
        return $ids ?? [];
    }

    public static function basketSession(array $post, CatalogProduct $product): void
    {
        $quantity = $post['quantity'];
        $ids = session('basket', []);
        if (empty($ids['items'])) {
            $ids['items'] = [];
        }
        if (array_key_exists($post['catalog_product_id'], $ids['items'])) {
            if (empty($post['is_add'])) {
                $ids['items'][$product->id]['quantity'] = $quantity;
            } else if (!$product->is_single) {
                $ids['items'][$product->id]['quantity'] += $quantity;
            }
        } else {
            $ids['items'][$product->id]['quantity'] = $quantity;
        }
        $ids['items'][$product->id]['alias'] = $product->alias;
        $ids['items'][$product->id]['is_single'] = $product->is_single;
        $ids['items'][$product->id]['title'] = $product->title_short ?? $product->title;
        $ids['items'][$product->id]['price'] = $product->price;
        $ids['items'][$product->id]['image'] = $product->getImage();
        $ids['items'][$product->id]['real_quantity'] = $product->in_stock + $product->in_reserve;
        if ($ids['items'][$product->id]['quantity'] <= 0) {
            unset($ids['items'][$product->id]);
        }
        session(['basket' => $ids]);
    }

    public static function createOrUpdate(array $post): self
    {
        /* @var $model self */
        if (empty($post['basket_id']) || !$model = self::query()->find($post['basket_id'])) {
            $model = new self();
        }
        $model->user_id = $post['user_id'];
        $model->catalog_product_id = $post['catalog_product_id'];
        $model->document_order_id = $post['document_order_id'] ?? null;
        $model->currency_id = $post['currency_id'] ?? null;
        $model->status = $post['status'] ?? self::STATUS_NEW;
        $model->quantity = $post['quantity'] ?? 1;
        $model->setDocumentOrderId();
        return $model->safe();
    }

    public static function getBasket(?int $user_id): array
    {
        /* @var $basket self[] */
        $array = [];
        $sum = 0.0;
        $quantity = 0;
        if ($user_id) {
            $basket = self::filter()
                ->where('user_id', $user_id)
                ->get();
            if (count($basket)) {
                foreach ($basket as $item) {
                    $array['items'][$item->catalog_product_id]['alias'] = $item->alias;
                    $array['items'][$item->catalog_product_id]['title'] = $item->title;
                    $array['items'][$item->catalog_product_id]['price'] = $item->price;
                    $array['items'][$item->catalog_product_id]['image'] = $item->getImage();
                    $array['items'][$item->catalog_product_id]['quantity'] = $item->quantity;
                    $array['items'][$item->catalog_product_id]['is_single'] = $item->is_single;
                    $array['items'][$item->catalog_product_id]['real_quantity'] = (int)$item->in_stock + (int)$item->in_reserve;
                    $quantity += $item->quantity;
                    $sum += $item->price * $item->quantity;
                }
                $array['sum'] = (float)$sum;
                $array['quantity'] = $quantity;
            }
        } else {
            $ids = session('basket', []);
            $items = $ids['items'] ?? [];
            foreach ($items as $item) {
                $quantity += $item['quantity'];
                $sum += $item['price'] * $item['quantity'];
            }
            $ids['sum'] = (float)$sum;
            $ids['quantity'] = $quantity;
            session(['basket' => empty($ids['items']) ? [] : $ids]);
            $array = session('basket', []);
        }
        return $array;
    }

    public static function changeBasket(array $post): array
    {
        /* @var $product CatalogProduct */
        if ($product = CatalogProduct::stock()->find($post['catalog_product_id'])) {
            if ($product->is_single) {
                $post['quantity'] = empty($post['quantity']) ? 0 : 1;
            } else {
                $post['quantity'] = $post['quantity'] ?? 1;
            }
            if (empty($post['user_id'])) {
                self::basketSession($post, $product);
            } else {
                /* @var $model self */
                $model = self::filter($post)->first();
                if ($model) {
                    $model->quantity = $post['quantity'];
                    if ($model->quantity > 0) {
                        $model->safe();
                    } else {
                        $model->delete();
                    }
                } else {
                    self::createOrUpdate($post);
                }
            }
            $ids = self::getBasket($post['user_id'] ?? null);
        }
        return $ids ?? [];
    }

    public static function deleteBasket(array $post): array
    {
        /* @var $product CatalogProduct */
        if ($product = CatalogProduct::stock()->find($post['catalog_product_id'])) {
            if (empty($post['user_id'])) {
                $ids = session('basket', []);
                if (array_key_exists($post['catalog_product_id'], $ids['items'])) {
                    $quantity = $post['quantity'] ?? $ids['items'][$product->id]['quantity'];
                    $ids['items'][$product->id]['quantity'] -= $quantity;
                    if ($ids['items'][$product->id]['quantity'] <= 0) {
                        unset($ids['items'][$product->id]);
                    }
                }
                session(['basket' => $ids]);
            } else {
                /* @var $model self */
                $model = self::filter($post)->first();
                if ($model) {
                    $quantity = $post['quantity'] ?? $model->quantity;
                    $model->quantity -= $quantity;
                    if ($model->quantity <= 0) {
                        $model->delete();
                    } else {
                        $model->safe();
                    }
                }
            }
            $ids = self::getBasket($post['user_id'] ?? null);
        }
        return $ids ?? [];
    }

    public static function toggleType(array $post): Collection
    {
        /* @var $products CatalogProduct[] */
        $inst = [];
        $model = new self();
        if (($ids = session('basket', [])) && isset($ids['items'])) {
            self::clearUserBasket($post['user_id']);
            $products = CatalogProduct::stock()->whereIn(CatalogProduct::table('id'), array_keys($ids['items']))->get();
            if (count($products)) {
                foreach ($products as $product) {
                    $data = [
                        'catalog_product_id' => $product->id,
                        'user_id' => $post['user_id'],
                        'ip' => $post['ip'],
                        'quantity' => $ids['items'][$product->id]['quantity']
                    ];
                    $basket = static::createOrUpdate($data);
                    if ($err = $basket->getErrors()) {
                        $model->setErrors(['basket' => $err]);
                    } else {
                        $inst[] = $basket;
                    }
                }
            }
        }
        session(['basket' => []]);
        return new Collection($inst);
    }

    public static function clearUserBasket(int $user_id = null): void
    {
        if ($user_id) {
            $basket = self::query()
                ->where('user_id', $user_id)
                ->get();
            if (count($basket)) {
                foreach ($basket as $item) {
                    $item->delete();
                }
                if ($catalogOrder = DocumentOrder::getByUser($user_id)) {
                    $catalogOrder->delete();
                }
            }
        } else {
            session(['basket' => []]);
        }
    }

    public function setDocumentOrderId(): void
    {
        if ($catalogOrder = DocumentOrder::getByUser($this->user_id)) {
            $this->document_order_id = $catalogOrder->id;
        }
    }

    public static function updateOrder(int $user_id): void
    {
        if ($catalogOrder = DocumentOrder::getByUser($user_id)) {
            $update = self::query()
                ->where('user_id', $user_id)
                ->update(['document_order_id' => $catalogOrder->id]);
        }
    }
}
