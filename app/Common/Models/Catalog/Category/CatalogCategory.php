<?php

namespace App\Common\Models\Catalog\Category;

use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Render;
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
 * @property CatalogCategory[] $catalogCategories
 * @property CatalogCategory[] $categories
 * @property Gallery[] $manyGalleryWithImages
 * @property Gallery[] $manyGallery
 * @property Render $render
 * @property CatalogProduct[] $products
 * @property CatalogProduct[] $productsRandom
 */
class CatalogCategory extends BaseModel
{
    use SeoSetter, EventSetter;

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

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'render_id' => 'Render ID',
            'gallery_id' => 'Gallery ID',
            'is_published' => 'Is Published',
            'is_favourites' => 'Is Favourites',
            'is_watermark' => 'Is Watermark',
            'image' => 'Image',
            'show_image' => 'Show Image',
            'url' => 'Url',
            'alias' => 'Alias',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'description' => 'Description',
            'preview_description' => 'Preview Description',
            'title_seo' => 'Title Seo',
            'description_seo' => 'Description Seo',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function deleteCatalogProducts(): void
    {
        $products = $this->products;
        foreach ($products as $product) {
            $product->delete();
        }
    }

    public function deleteCatalogCategories(): void
    {
        $categories = $this->categories;
        foreach ($categories as $category) {
            $category->delete();
        }
    }

    protected function deleteGallery(): void
    {
        $this->gallery()->delete();
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
        return $this->hasMany(CatalogProduct::class, 'category_id', 'id')
            ->select([
                CatalogProduct::table('*'),
                CatalogStorage::table('price_out') . ' as price'
            ])
            ->join(CatalogStorage::table(), CatalogStorage::table('catalog_product_id'), '=', CatalogProduct::table('id'))
            ->where(function ($query) {
                $query->where(CatalogStorage::table('in_stock'), '>', 0)
                    ->orWhere(static function ($query) {
                        $query->where(CatalogStorage::table('in_reserve'), '>', 0)
                            ->where(CatalogStorage::table('reserve_expired_at'), '<', time());
                    });
            })
            ->inRandomOrder();
    }

    public function products(): HasMany
    {
        return $this->hasMany(CatalogProduct::class, 'category_id', 'id')
            ->select([
                CatalogProduct::table('*'),
                CatalogStorage::table('price_out') . ' as price'
            ])
            ->join(CatalogStorage::table(), CatalogStorage::table('catalog_product_id'), '=', CatalogProduct::table('id'))
            ->where(function ($query) {
                $query->where(CatalogStorage::table('in_stock'), '>', 0)
                    ->orWhere(static function ($query) {
                        $query->where(CatalogStorage::table('in_reserve'), '>', 0)
                            ->where(CatalogStorage::table('reserve_expired_at'), '<', time());
                    });
            })
            ->orderBy(CatalogProduct::table() . '.created_at', 'desc');
    }

    protected function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $catalog = self::query()
            ->where('alias', $alias)
            ->when($id, function ($query, $id) {
                $query->where('id', '!=', $id);
            })->first();
        if ($catalog) {
            return true;
        }
        return false;
    }

    public static function createOrUpdate(array $post): static
    {
        if (empty($post['id']) || !$model = self::query()->where('id', $post['id'])->first()) {
            $model = new self();
        }
        $model->category_id = $post['category_id'] ?? null;
        $model->render_id = $post['render_id'] ?? null;
        $model->is_published = empty($post['is_published']) ? 0 : 1;
        $model->is_favourites = empty($post['is_favourites']) ? 0 : 1;
        $model->is_watermark = empty($post['is_watermark']) ? 0 : 1;
        $model->show_image = empty($post['show_image']) ? 0 : 1;
        $model->title_short = $post['title_short'] ?? null;
        $model->description = $post['description'] ?? null;
        $model->preview_description = $post['preview_description'] ?? null;
        $model->sort = $post['sort'] ?? null;
        $model->setTitle($post);
        $model->setAlias($post);
        $model->createdAtSet($post['created_at'] ?? null);
        $model->url = $model->alias;
        if ($model->safe()->getErrors()) {
            return $model;
        }
        $post['images_path'] = $model->setImagesPath();
        if (!empty($post['image'])) {
            $model->setImage($post);
        }
        if (!empty($post['galleries'])) {
            $model->setGalleries($post['galleries']);
        }
        $model->setSeo($post['seo'] ?? []);
        return $model->safe();
    }
}
