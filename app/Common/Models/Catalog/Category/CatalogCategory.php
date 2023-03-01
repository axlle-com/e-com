<?php

namespace App\Common\Models\Catalog\Category;

use App\Common\Models\Catalog\BaseCatalog;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Gallery\HasGallery;
use App\Common\Models\Gallery\HasGalleryImage;
use App\Common\Models\History\HasHistory;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Render;
use App\Common\Models\Url\HasUrl;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%catalog_category}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $category_title
 * @property string|null $category_title_short
 * @property int|null $render_id
 * @property string|null $render_title
 * @property string|null $render_name
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_watermark
 * @property string|null $image
 * @property int|null $show_image
 * @property string $url
 * @property string $alias
 * @property string $title
 * @property string|null $title_short
 * @property string|null $description
 * @property string|null $preview_description
 * @property string|null $title_seo
 * @property string|null $description_seo
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogCategory $category
 * @property Collection<CatalogCategory> $catalogCategories
 * @property Collection<CatalogCategory> $categories
 * @property Render $render
 * @property Collection<CatalogProduct> $products
 * @property Collection<CatalogProduct> $productsRandom
 */
class CatalogCategory extends BaseCatalog
{
    use SeoSetter;
    use HasHistory;
    use HasUrl;
    use HasGallery;
    use HasGalleryImage;

    protected $table = 'ax_catalog_category';

    public static function rules(string $type = 'create'): array
    {
        return [
            'create' => [
                'id' => 'nullable|integer',
                'category_id' => 'nullable|integer',
                'gallery_id' => 'nullable|integer',
                'render_id' => 'nullable|integer',
                'is_published' => 'nullable|string',
                'is_favourites' => 'nullable|string',
                'is_watermark' => 'nullable|string',
                'show_image' => 'nullable|string',
                'title' => 'required|string',
                'title_short' => 'nullable|string',
                'description' => 'nullable|string',
                'preview_description' => 'nullable|string',
                'title_seo' => 'nullable|string',
                'description_seo' => 'nullable|string',
                'sort' => 'nullable|integer',
                'created_at' => 'nullable|string',
            ],
            'create_db' => [
                'id' => 'nullable|integer',
                'category_id' => 'nullable|integer',
                'gallery_id' => 'nullable|integer',
                'render_id' => 'nullable|integer',
                'is_published' => 'nullable|string',
                'is_favourites' => 'nullable|string',
                'is_watermark' => 'nullable|string',
                'show_image' => 'nullable|string',
                'title' => 'required|string',
                'alias' => 'required|string',
                'url' => 'required|string',
                'title_short' => 'nullable|string',
                'description' => 'nullable|string',
                'preview_description' => 'nullable|string',
                'title_seo' => 'nullable|string',
                'description_seo' => 'nullable|string',
                'sort' => 'nullable|integer',
                'created_at' => 'nullable|string',
            ],
            'filter' => [
                'category' => 'nullable|integer',
                'render' => 'nullable|integer',
                'published' => 'nullable|integer',
                'favourites' => 'nullable|integer',
                'title' => 'nullable|string',
                'description' => 'nullable|string',
            ],
        ][$type] ?? [];
    }

    public function deleteCatalogProducts(): void
    {
        $products = $this->products;
        foreach($products as $product) {
            $product->delete();
        }
    }

    public function deleteCatalogCategories(): void
    {
        $categories = $this->categories;
        foreach($categories as $category) {
            $category->delete();
        }
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'category_id', 'id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(__CLASS__, 'category_id', 'id');
    }

    public function render(): BelongsTo
    {
        return $this->belongsTo(Render::class, 'render_id', 'id');
    }

    public function productsRandom(): HasMany
    {
        return $this->hasMany(CatalogProduct::class, 'category_id', 'id')->select([
            CatalogProduct::table('*'),
            CatalogStorage::table('price_out') . ' as price',
        ])->join(
            CatalogStorage::table(), CatalogStorage::table('catalog_product_id'), '=', CatalogProduct::table('id')
        )->where(function($query) {
            $query->where(CatalogStorage::table('in_stock'), '>', 0)->orWhere(static function($query) {
                $query->where(CatalogStorage::table('in_reserve'), '>', 0)->where(
                    CatalogStorage::table('reserve_expired_at'), '<', time()
                );
            });
        })->inRandomOrder();
    }

    public function products(): HasMany
    {
        return $this->hasMany(CatalogProduct::class, 'category_id', 'id')->select([
            CatalogProduct::table('*'),
            CatalogStorage::table('price_out') . ' as price',
        ])->join(
            CatalogStorage::table(), CatalogStorage::table('catalog_product_id'), '=', CatalogProduct::table('id')
        )->where(function($query) {
            $query->where(CatalogStorage::table('in_stock'), '>', 0)->orWhere(static function($query) {
                $query->where(CatalogStorage::table('in_reserve'), '>', 0)->where(
                    CatalogStorage::table('reserve_expired_at'), '<', time()
                );
            });
        })->orderBy(CatalogProduct::table() . '.created_at', 'desc');
    }

    public static function createOrUpdate(array $post): static
    {
        /** @var static $model */
        if(empty($post['id']) || !$model = static::query()->where(static::table() . '.id', $post['id'])->first()) {
            return static::create($post);
        }

        return $model->loadModel($post)->safe('title_seo', 'description_seo');
    }
}
