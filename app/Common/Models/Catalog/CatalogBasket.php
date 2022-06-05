<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Ips;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\Status;
use App\Common\Models\User\User;
use App\Common\Models\Wallet\Currency;

/**
 * This is the model class for table "ax_catalog_basket".
 *
 * @property int $id
 * @property int $user_id
 * @property int $catalog_product_id
 * @property int|null $catalog_order_id
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
 *
 * @property CatalogDocument $catalogDocument
 * @property CatalogProduct $catalogProduct
 * @property Currency $currency
 * @property Ips $ips
 * @property User $user
 */
class CatalogBasket extends BaseModel implements Status
{
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

    public static function createOrUpdate(array $post): self
    {
        /* @var $model self */
        if (empty($post['basket_id']) || !$model = self::query()->find($post['basket_id'])) {
            $model = new self();
        }
        $ip = Ips::createOrUpdate($post);
        $model->user_id = $post['user_id'];
        $model->catalog_product_id = $post['catalog_product_id'];
        $model->catalog_order_id = $post['catalog_order_id'] ?? null;
        $model->currency_id = $post['currency_id'] ?? null;
        $model->ips_id = $ip->getErrors() ? null : $ip->id;
        $model->status = $post['status'] ?? self::STATUS_DRAFT;
        $model->quantity = $post['quantity'] ?? 1;
        return $model->safe();
    }

    public static function getBasket(?int $user_id): array
    {
        /* @var $basket self[] */
        $array = [];
        if ($user_id) {
            $basket = self::filter()
                ->where('user_id', $user_id)
                ->get();
            if (count($basket)) {
                $sum = 0.0;
                $quantity = 0;
                foreach ($basket as $item) {
                    $array['items'][$item->catalog_product_id]['alias'] = $item->alias;
                    $array['items'][$item->catalog_product_id]['title'] = $item->title;
                    $array['items'][$item->catalog_product_id]['price'] = $item->price;
                    $array['items'][$item->catalog_product_id]['image'] = $item->getImage();
                    $array['items'][$item->catalog_product_id]['quantity'] = $item->quantity;
                    $array['items'][$item->catalog_product_id]['real_quantity'] = (int)$item->in_stock + (int)$item->in_reserve;
                    $quantity++;
                    $sum += $item->price * $item->quantity;
                }
                $array['sum'] = (float)$sum;
                $array['quantity'] = $quantity;
            }
        } else {
            $array = session('basket', []);
        }
        return $array;
    }

    public static function addBasket(array $post): array
    {
        /* @var $product CatalogProduct */
        $quantity = $post['quantity'] ?? 1;
        if ($product = CatalogProduct::quantity()->find($post['catalog_product_id'])) {
            if (empty($post['user_id'])) {
                $post['is_add'] = true;
                self::basketSession($post, $product);
            } else {
                /* @var $model self */
                $model = self::filter($post)->first();
                if ($model) {
                    $model->quantity += $quantity;
                    $model->safe();
                } else {
                    self::createOrUpdate($post);
                }
            }
            $ids = self::getBasket($post['user_id'] ?? null);
        }
        return $ids ?? [];
    }

    public static function changeBasket(array $post): array
    {
        /* @var $product CatalogProduct */
        $quantity = $post['quantity'];
        if ($product = CatalogProduct::quantity()->find($post['catalog_product_id'])) {
            if (empty($post['user_id'])) {
                self::basketSession($post, $product);
            } else {
                /* @var $model self */
                $model = self::filter($post)->first();
                if ($model) {
                    $model->quantity = $quantity;
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

    public static function basketSession(array $post, CatalogProduct $product): void
    {
        $quantity = $post['quantity'] ?? 1;
        $ids = session('basket', []);
        if (empty($ids)) {
            $ids['sum'] = 0.0;
            $ids['quantity'] = 0;
            $ids['items'] = [];
        }
        if (array_key_exists($post['catalog_product_id'], $ids['items'])) {
            if (empty($post['is_add'])) {
                $ids['sum'] -= $product->price * $ids['items'][$product->id]['quantity'];
                $ids['sum'] += $product->price * $quantity;
                $ids['quantity'] -= $ids['items'][$product->id]['quantity'];
                $ids['quantity'] += $quantity;
                $ids['items'][$product->id]['quantity'] = $quantity;
            } else {
                $ids['sum'] += $product->price;
                $ids['quantity'] += $quantity;
                $ids['items'][$product->id]['quantity'] += $quantity;
            }
        } else {
            $ids['sum'] += $product->price;
            $ids['quantity'] += $quantity;
            $ids['items'][$product->id]['quantity'] = $quantity;
        }
        $ids['items'][$product->id]['alias'] = $product->alias;
        $ids['items'][$product->id]['title'] = $product->title_short ?? $product->title;
        $ids['items'][$product->id]['price'] = $product->price;
        $ids['items'][$product->id]['image'] = $product->getImage();
        $ids['items'][$product->id]['real_quantity'] = $product->in_stock + $product->in_reserve;
        session(['basket' => $ids]);
    }

    public static function deleteBasket(array $post): array
    {
        /* @var $product CatalogProduct */
        if ($product = CatalogProduct::quantity()->find($post['catalog_product_id'])) {
            if (empty($post['user_id'])) {
                $ids = session('basket', []);
                if (array_key_exists($post['catalog_product_id'], $ids['items'])) {
                    $quantity = $post['quantity'] ?? $ids['items'][$product->id]['quantity'];
                    $ids['sum'] -= $product->price;
                    $ids['quantity'] -= $quantity ?? $ids['items'][$product->id]['quantity'];
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

    public static function toggleType(array $post): self
    {
        /* @var $products CatalogProduct[] */
        $inst = [];
        $collection = new self();
        if (($ids = session('basket', [])) && isset($ids['items'])) {
            self::clearUserBasket($post['user_id']);
            $products = CatalogProduct::quantity()->whereIn('id', array_keys($ids['items']))->get();
            if (count($products)) {
                foreach ($products as $product) {
                    $data = [
                        'catalog_product_id' => $product->id,
                        'user_id' => $post['user_id'],
                        'ip' => $post['ip'],
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

    public static function clearUserBasket(int $user_id = null): void
    {
        if ($user_id) {
            $basket = self::filter()
                ->where('user_id', $user_id)
                ->get();
            if (count($basket)) {
                foreach ($basket as $item) {
                    $item->delete();
                }
            }
        } else {
            session(['basket' => []]);
        }
    }
}
