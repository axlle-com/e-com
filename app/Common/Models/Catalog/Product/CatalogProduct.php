<?php

namespace App\Common\Models\Catalog\Product;

use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Document\CatalogDocument;
use App\Common\Models\Catalog\Document\CatalogDocumentContent;
use App\Common\Models\Catalog\Document\CatalogDocumentSubject;
use App\Common\Models\Catalog\Property\CatalogProductHasValueDecimal;
use App\Common\Models\Catalog\Property\CatalogProductHasValueInt;
use App\Common\Models\Catalog\Property\CatalogProductHasValueText;
use App\Common\Models\Catalog\Property\CatalogProductHasValueVarchar;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyType;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Render;
use App\Common\Models\User\UserWeb;
use App\Common\Models\Wallet\Currency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "{{%catalog_product}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $category_title
 * @property string|null $category_title_short
 * @property int|null $render_id
 * @property string|null $render_title
 * @property string|null $render_name
 * @property int $is_published
 * @property int $is_single
 * @property int|null $is_favourites
 * @property int|null $is_comments
 * @property int|null $is_watermark
 * @property string|null $media
 * @property string $url
 * @property string $alias
 * @property string $title
 * @property float|null $price
 * @property string|null $title_short
 * @property string|null $preview_description
 * @property string|null $description
 * @property string|null $title_seo
 * @property string|null $description_seo
 * @property int|null $show_date
 * @property string|null $image
 * @property int|null $hits
 * @property int|null $sort
 * @property float|null $stars
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property int|null $in_stock
 * @property int|null $in_reserve
 *
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogDocumentContent[] $catalogDocumentContents
 * @property CatalogCategory $category
 * @property Render $render
 * @property CatalogProductHasCurrency[] $catalogProductHasCurrencies
 * @property Currency[] $currencies
 * @property CatalogProductHasValueDecimal[] $catalogProductHasValueDecimals
 * @property CatalogProductHasValueInt[] $catalogProductHasValueInts
 * @property CatalogProductHasValueText[] $catalogProductHasValueTexts
 * @property CatalogProductHasValueVarchar[] $catalogProductHasValueVarchars
 * @property CatalogProductWidgets[] $catalogProductWidgets
 * @property CatalogProductWidgets[] $catalogProductWidgetsWithContent
 * @property CatalogProductWidgets $widgetTabs
 * @property CatalogStorage[] $catalogStorages
 * @property CatalogStoragePlace[] $catalogStoragePlaces
 * @property Gallery[] $manyGalleryWithImages
 * @property Gallery[] $manyGallery
 */
class CatalogProduct extends BaseModel
{
    use SeoSetter, EventSetter;

    public bool $setDocument = true;

    protected $table = 'ax_catalog_product';
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'price' => 'float',
    ];

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
                    'id' => 'nullable|integer',
                    'category_id' => 'nullable|integer',
                    'render_id' => 'nullable|integer',
                    'is_published' => 'nullable|string',
                    'is_favourites' => 'nullable|string',
                    'is_watermark' => 'nullable|string',
                    'is_comments' => 'nullable|string',
                    'show_date' => 'nullable|string',
                    'show_image' => 'nullable|string',
                    'title' => 'required|string',
                    'price' => 'required|integer',
                    'title_short' => 'nullable|string',
                    'description' => 'nullable|string',
                    'preview_description' => 'nullable|string',
                    'title_seo' => 'nullable|string',
                    'description_seo' => 'nullable|string',
                    'sort' => 'nullable|integer',
                    'images' => 'nullable|array',
                    'images.*.id' => 'nullable|integer',
                    'images.*.title' => 'nullable|string',
                    'images.*.description' => 'nullable|string',
                    'images.*.sort' => 'nullable|integer',
                    'tabs' => 'nullable|array',
                    'tabs.*.id' => 'nullable|integer',
                    'tabs.*.title' => 'required|string',
                    'tabs.*.title_short' => 'nullable|string',
                    'tabs.*.description' => 'nullable|string',
                    'tabs.*.sort' => 'nullable|integer',
                    'property' => 'nullable|array',
                    'property.*.property_id' => 'required|integer',
                    'property.*.property_unit_id' => 'nullable|string',
                    'property.*.property_value_sort' => 'nullable|string',
                    'property.*.property_value' => 'required|string',
                ],
            ][$type] ?? [];
    }

    public function createDocument(): void
    {
        if ($this->is_published && $this->isDirty('is_published') && $this->setDocument) {
            $user = UserWeb::auth();
            $subject = CatalogDocumentSubject::query()
                ->select([
                    'ax_catalog_document_subject.*',
                    't.id as type_id',
                    't.name as type_name',
                ])
                ->join('ax_fin_transaction_type as t', 't.id', '=', 'ax_catalog_document_subject.fin_transaction_type_id')
                ->where('ax_catalog_document_subject.name', 'coming')
                ->first();
            $data = [
                'catalog_document_subject_id' => $subject->id ?? null,
                'user_id' => $user->id,
                'ip' => $user->ip,
                'status' => 1,
                'content' => [
                    [
                        'catalog_product_id' => $this->id,
                        'price_out' => $this->price,
                        'quantity' => $this->quantity ?: 1,
                    ]
                ],
            ];
            $doc = CatalogDocument::createOrUpdate($data);
            if ($err = $doc->getErrors()) {
                $this->setErrors($err);
            } elseif ($err = $doc->posting()->getErrors()) {
                $this->setErrors($err);
            }
        }
    }

    public function deleteCatalogProductWidgets(): void
    {
        $catalogProductWidgets = $this->catalogProductWidgets;
        foreach ($catalogProductWidgets as $widget) {
            $widget->delete();
        }
    }

    public function deleteProperties(): void
    {
        foreach (CatalogPropertyType::$types as $key => $type) {
            DB::table($type)
                ->where('catalog_product_id', $this->id)
                ->delete();
        }
    }

    public static function quantity(): Builder
    {
        return self::query()
            ->select([
                self::table('*'),
                'ax_catalog_storage.in_stock',
                'ax_catalog_storage.in_reserve',
                'ax_catalog_storage.reserve_expired_at',
            ])
            ->leftJoin('ax_catalog_storage', 'ax_catalog_storage.catalog_product_id', '=', self::table('id'));
    }

    public static function inStock(): Builder
    {
        return self::query()
            ->select([
                self::table('*'),
                'ax_catalog_storage.in_stock',
                'ax_catalog_storage.in_reserve',
                'ax_catalog_storage.reserve_expired_at',
            ])
            ->join('ax_catalog_storage', 'ax_catalog_storage.catalog_product_id', '=', self::table('id'))
            ->where(function ($query) {
                $query->where('ax_catalog_storage.in_stock', '>', 0)
                    ->orWhere(static function ($query) {
                        $query->where('ax_catalog_storage.in_reserve', '>', 0)
                            ->where('ax_catalog_storage.reserve_expired_at', '<', time());
                    });
            });
    }

    public static function createOrUpdate(array $post): static
    {
        /* @var $gallery Gallery */
        if (empty($post['id']) || !$model = self::query()->where(self::table() . '.id', $post['id'])->first()) {
            $model = new self();
        }
        $model->category_id = $post['category_id'] ?? null;
        $model->render_id = $post['render_id'] ?? null;
        $model->is_favourites = empty($post['is_favourites']) ? 0 : 1;
        $model->is_watermark = empty($post['is_watermark']) ? 0 : 1;
        $model->is_comments = empty($post['is_comments']) ? 0 : 1;
        $model->is_single = empty($post['is_single']) ? 0 : 1;
        $model->title_short = $post['title_short'] ?? null;
        $model->description = $post['description'] ?? null;
        $model->preview_description = $post['preview_description'] ?? null;
        $model->sort = $post['sort'] ?? null;
        $model->setPrice($post['price'] ?? null);
        $model->setTitle($post);
        $model->setAlias($post);
        $model->createdAtSet($post['created_at'] ?? null);
        $model->setIsPublished($post['is_published'] ?? null);
        $model->url = $model->alias;
        if ($model->safe()->getErrors()) {
            return $model;
        }
        $post['catalog_product_id'] = $model->id;
        if (!empty($post['image'])) {
            $model->setImage($post);
        }
        if (!empty($post['galleries'])) {
            $model->setGalleries($post['galleries']);
        }
        if (!empty($post['tabs'])) {
            $post['title'] = $model->title;
            $productWidgets = CatalogProductWidgets::createOrUpdate($post);
            if ($errors = $productWidgets->getErrors()) {
                $model->setErrors(['widgets' => $errors]);
            }
        }
        if (!empty($post['property'])) {
            $model->setProperty($post['property']);
        }
        $model->setSeo($post['seo'] ?? []);
        return $model->safe();
    }

    public function setPrice(?float $value = null): self
    {
        if (!empty($value)) {
            $this->price = round($value, 2);
        }
        return $this;
    }

    public function setIsPublished(?string $value): self
    {
        if (!$this->is_published) {
            $this->is_published = empty($value) ? 0 : 1;
        }
        return $this;
    }

    public function setProperty(array $properties = null): self
    {
        $err = [];
        foreach ($properties as $prop) {
            $prop['catalog_product_id'] = $this->id;
            $err[] = CatalogProperty::setValue($prop);
        }
        if (in_array(false, $err, true)) {
            return $this->setErrors(['property_value' => 'Были ошибки при записи']);
        }
        return $this;
    }

    public static function deleteProperty(array $post): int
    {
        return DB::table($post['model'])
            ->where('id', $post['id'])
            ->delete();
    }

    public static function saveSort(array $post): void
    {
        $models = [];
        $min = PHP_INT_MAX;
        foreach ($post['ids'] as $id) { # TODO: в каком порядке одним запросом
            /* @var $model self */
            if ($model = self::query()->find($id)) {
                $models[] = $model;
                if ($model->created_at < $min) {
                    $min = $model->created_at;
                }
            }
        }
        $models = array_reverse($models);
        foreach ($models as $model) {
            $min += 60;
            $model->created_at = $min;
            $model->save();
        }
    }

    # TODO: реализовать красиво
    public static function search(string $string): ?Collection
    {
        return self::query()
            ->select([
                self::table('id'),
                self::table('title') . ' as text',
//                CatalogStorage::table('in_stock') . ' as in_stock',
//                CatalogStorage::table('in_reserve') . ' as in_reserve',
//                CatalogStorage::table('reserve_expired_at') . ' as reserve_expired_at',
//                CatalogStorage::table('price_in') . ' as price_in',
//                CatalogStorage::table('price_out') . ' as price_out',
            ])
//            ->leftJoin(CatalogStorage::table(), CatalogStorage::table('catalog_product_id'), '=', self::table('id'))
            ->where('title', 'like', '%' . $string . '%')
            ->orWhere('description', 'like', '%' . $string . '%')
            ->orWhere('title_short', 'like', '%' . $string . '%')
            ->orWhere(self::table('id'), 'like', '%' . $string . '%')
            ->get();
    }

    public function catalogBaskets(): HasMany
    {
        return $this->hasMany(CatalogBasket::class, 'catalog_product_id', 'id');
    }

    public function catalogDocumentContents(): HasMany
    {
        return $this->hasMany(CatalogDocumentContent::class, 'catalog_product_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CatalogCategory::class, 'category_id', 'id');
    }

    public function render(): BelongsTo
    {
        return $this->belongsTo(Render::class, 'render_id', 'id');
    }

    public function catalogProductWidgets(): HasMany
    {
        return $this->hasMany(CatalogProductWidgets::class, 'catalog_product_id', 'id');
    }

    public function catalogProductWidgetsWithContent(): HasMany
    {
        return $this->hasMany(CatalogProductWidgets::class, 'catalog_product_id', 'id')
            ->with('content');
    }

    public function widgetTabs(): BelongsTo
    {
        return $this->belongsTo(CatalogProductWidgets::class, 'id', 'catalog_product_id')
            ->where('name', CatalogProductWidgets::WIDGET_TABS)
            ->with('content');
    }

    public function catalogStorages(): HasMany
    {
        return $this->hasMany(CatalogStorage::class, 'catalog_product_id', 'id');
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getProperty(): array|Collection
    {
        $arr = [];
        foreach (CatalogPropertyType::$types as $type => $table) {
            $arr[$type] = DB::table($table . ' as ' . $type)
                ->select([
                    $type . '.id as property_value_id',
                    $type . '.value as property_value',
                    $type . '.sort as property_value_sort',
                    $type . '.catalog_product_id as catalog_product_id',
                    $type . '.catalog_property_id as property_id',
                    $type . '.catalog_property_unit_id as property_unit_id',
                    'prop.title as property_title',
                    'type.title as type_title',
                    'type.resource as type_resource',
                    'unit.title as unit_title',
                    'unit.national_symbol as unit_symbol',
                ])
                ->join('ax_catalog_property as prop', 'prop.id', '=', $type . '.catalog_property_id')
                ->join('ax_catalog_property_type as type', 'type.id', '=', 'prop.catalog_property_type_id')
                ->leftJoin('ax_catalog_property_unit as unit', 'unit.id', '=', $type . '.catalog_property_unit_id')
                ->where('catalog_product_id', $this->id);
        }
        $all = $arr['text']
            ->union($arr['int'])
            ->union($arr['double'])
            ->union($arr['varchar'])
            ->orderBy('property_value_sort')
            ->get();
        return count($all) ? $all : [];
    }

    protected function deleteWidgetTabs(): void
    {
        if ($this->widgetTabs) {
            $this->widgetTabs->delete();
        }
    }

    protected function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $post = self::query()
            ->where('alias', $alias)
            ->when($id, function ($query, $id) {
                $query->where('id', '!=', $id);
            })->first();
        if ($post) {
            return true;
        }
        return false;
    }

    public static function postingById(int $id):self
    {
        /* @var $product self */
        if ($product = self::query()->where('is_published', 0)->find($id)) {
            $product->is_published = 1;
            $product->setDocument = false;
            return $product->safe();
        }
        return new self();
    }
}
