<?php

namespace App\Common\Models\Catalog\Product;

use App\Common\Models\Catalog\CatalogBasket;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\Document\CatalogDocumentContent;
use App\Common\Models\Catalog\Document\DocumentComing;
use App\Common\Models\Catalog\Property\CatalogProductHasValueDecimal;
use App\Common\Models\Catalog\Property\CatalogProductHasValueInt;
use App\Common\Models\Catalog\Property\CatalogProductHasValueText;
use App\Common\Models\Catalog\Property\CatalogProductHasValueVarchar;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyType;
use App\Common\Models\Catalog\Storage\CatalogStorage;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Comment;
use App\Common\Models\Errors\_Errors;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\Main\SeoSetter;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\User\User;
use App\Common\Models\User\UserGuest;
use App\Common\Models\User\UserWeb;
use App\Common\Models\Wallet\Currency;
use Exception;
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
 * @property int|null $quantity
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
 * @property Comment[] $comments
 */
class CatalogProduct extends BaseModel
{
    use SeoSetter, EventSetter;

    public bool $setDocument = true;
    public float $price_in = 0.0;
    public float $price_out = 0.0;

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
                'price_in' => 'required|integer',
                'price_out' => 'required|integer',
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

    public static function stock(): Builder
    {
        return self::query()->select([
            self::table('*'),
            'ax_catalog_storage.price_out as price',
            'ax_catalog_storage.in_stock',
            'ax_catalog_storage.in_reserve',
            'ax_catalog_storage.reserve_expired_at',
        ])->leftJoin('ax_catalog_storage', 'ax_catalog_storage.catalog_product_id', '=', self::table('id'));
    }

    public static function inStock(): Builder
    {
        return self::query()
            ->select([
                self::table('*'),
                'ax_catalog_storage.price_out as price',
                'ax_catalog_storage.in_stock',
                'ax_catalog_storage.in_reserve',
                'ax_catalog_storage.reserve_expired_at',
            ])
            ->join('ax_catalog_storage', 'ax_catalog_storage.catalog_product_id', '=', self::table('id'))
            ->where(function ($query) {
                $query->where('ax_catalog_storage.in_stock', '>', 0)->orWhere(static function ($query) {
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
        $model->setPrice($post['price_out'] ?? null);
        $model->setPriceOut($post['price_out'] ?? null);
        $model->setPriceIn($post['price_in'] ?? null);
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
                $model->setErrors($errors);
            }
        }
        if (!empty($post['property'])) {
            $model->setProperty($post['property']);
        }
        $model->setSeo($post['seo'] ?? []);
        return $model->safe();
    }

    public static function deleteProperty(array $post): int
    {
        return DB::table($post['model'])->where('id', $post['id'])->delete();
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

    public static function postingById(int $id): self
    {
        /* @var $product self */
        if ($product = self::query()->where('is_published', 0)->find($id)) {
            $product->is_published = 1;
            $product->setDocument = false;
            return $product->safe();
        }
        return new self();
    }

    public static function replaceInPortfolio(int $id): void
    {
        /**
         * @var $product self
         * @var $portfolio Page
         */
        $product = self::query()->where('is_single', 1)->find($id);
        $portfolio = Page::query()->with(['manyGallery'])->where('alias', 'portfolio')->first();
        $manyGallery = $portfolio->manyGallery[0] ?? null;
        if ($product && $product->image && $portfolio && $manyGallery) {
            $post = [
                'images_path' => $portfolio->setImagesPath(),
                'gallery_id' => $manyGallery->id,
                'images_copy' => 1,
                'images' => [
                    [
                        'file' => public_path($product->image),
                        'title' => $product->title,
                    ],
                ],
            ];
            $self = new GalleryImage;
            try {
                $image = GalleryImage::createOrUpdate($post);
                if ($err = $image->getErrors()) {
                    $self->setErrors($err);
                }
            } catch (Exception $exception) {
                $self->setErrors(_Errors::exception($exception, $self));
            }
        }
    }

    public static function getPropertyForDelivery(array $ids): array
    {
        $property = self::getSortPropertyForIds($ids, true);
        $data = [];
        foreach ($ids as $id) {
            if (empty($property[$id])) {
                $prod = new self(['id' => $id]);
                $prod->setErrors(_Errors::error('Не задано свойства для товара', $prod));
                return [];
            }
            $weight = $property[$id]['Вес'] ?? 1500;
            if (!$width = $property[$id]['Ширина'] ?? null) {
                $width0 = $property[$id]['Ширина сверху'] ?? 0;
                $width1 = $property[$id]['Ширина снизу'] ?? 0;
                $width = max($width0, $width1);
                if (!$width) {
                    $prod = new self(['id' => $id]);
                    $prod->setErrors(_Errors::error('Не задано свойства ширина для товара', $prod));
                    $width = 20;
                }
            }
            $data[] = [
                'weight' => round($weight),
                'length' => round($property[$id]['Длина'] ?? 30),
                'width' => round($width),
                'height' => round($property[$id]['Толщина'] ?? 4),
            ];
        }
        return $data;
    }

    public static function getSortPropertyForIds(array $ids, bool $withHidden = false): array|Collection
    {
        $arr = [];
        if ($all = self::getPropertyForIds($ids, $withHidden)) {
            foreach ($all as $item) {
                $arr[$item->catalog_product_id][$item->property_title] = $item->property_value;
            }
        }
        return $arr;
    }

    public static function getPropertyForIds(array $ids, bool $withHidden = false): array|Collection
    {
        $arr = [];
        foreach (CatalogPropertyType::$types as $type => $table) {
            $prop = 'prop_' . $type;
            $arr[$type] = DB::table($table . ' as ' . $type)
                ->select([
                    $type . '.id as property_value_id',
                    $type . '.value as property_value',
                    $type . '.sort as property_value_sort',
                    $type . '.catalog_product_id as catalog_product_id',
                    $type . '.catalog_property_id as property_id',
                    $type . '.catalog_property_unit_id as property_unit_id',
                    $prop . '.title as property_title',
                    'type.title as type_title',
                    'type.resource as type_resource',
                    'unit.title as unit_title',
                    'unit.national_symbol as unit_symbol',
                ])
                ->join('ax_catalog_property as ' . $prop, $prop . '.id', '=', $type . '.catalog_property_id')
                ->join('ax_catalog_property_type as type', 'type.id', '=', $prop . '.catalog_property_type_id')
                ->leftJoin('ax_catalog_property_unit as unit', 'unit.id', '=', $type . '.catalog_property_unit_id')
                ->whereIn($type . '.catalog_product_id', $ids);
            if (!$withHidden) {
                $arr[$type]->where(function ($query) use ($prop) {
                    $query->where($prop . '.is_hidden', 0)->orWhere($prop . '.is_hidden', null);
                });
            }

        }
        $all = $arr['text']->union($arr['int'])
            ->union($arr['double'])
            ->union($arr['varchar'])
            ->orderBy('property_value_sort')
            ->get();
        return count($all) ? $all : [];
    }

    public function setPrice(?float $value = null): self
    {
        if (!empty($value)) {
            $this->price = round($value, 2);
        }
        return $this;
    }

    public function setPriceOut(?float $value = null): self
    {
        if (!empty($value)) {
            $this->price_out = round($value, 2);
        }
        return $this;
    }

    # TODO: реализовать красиво

    public function setPriceIn(?float $value = null): self
    {
        if (!empty($value)) {
            $this->price_in = round($value, 2);
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
            return $this->setErrors(_Errors::error(['property_value' => 'Были ошибки при записи'], $this));
        }
        return $this;
    }

    public function createDocument(): void
    {
        if ($this->is_published && $this->isDirty('is_published') && $this->setDocument) {
            $user = UserWeb::auth();
            $data = [
                'status' => 1,
                'contents' => [
                    [
                        'catalog_product_id' => $this->id,
                        'price' => $this->price_in,
                        'price_out' => $this->price_out,
                        'quantity' => $this->quantity ?: 1,
                    ],
                ],
            ];
            $doc = DocumentComing::createOrUpdate($data);
            if ($err = $doc->getErrors()) {
                $this->setErrors($err);
            } else {
                if ($err = $doc->posting()->getErrors()) {
                    $this->setErrors($err);
                }
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
            DB::table($type)->where('catalog_product_id', $this->id)->delete();
        }
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
        return $this->hasMany(CatalogProductWidgets::class, 'catalog_product_id', 'id')->with('content');
    }

    public function comments(): HasMany
    {

        return $this->hasMany(Comment::class, 'resource_id', 'id')
            ->select([
                Comment::table('*'),
                User::table('first_name') . ' as user_name',
                UserGuest::table('name') . ' as user_guest_name',
            ])
            ->leftJoin(User::table(), static function ($join) {
                $join->on(Comment::table('person_id'), '=', User::table('id'))
                    ->where(Comment::table('person'), '=', User::table());
            })
            ->leftJoin(UserGuest::table(), static function ($join) {
                $join->on(Comment::table('person_id'), '=', UserGuest::table('id'))
                    ->where(Comment::table('person'), '=', UserGuest::table());
            })
            ->where('resource', $this->getTable())
            ->where('level', '<', 4);
    }

    public function getComments(): string
    {
        $html = '';
        if ($comments = Comment::convertToArray($this->comments->toArray())) {
            $html = Comment::getCommentsHtml($comments);
        }
        return $html;
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

    public function getProperty(bool $isHidden = false): array|Collection
    {
        $arr = [];
        foreach (CatalogPropertyType::$types as $type => $table) {
            $prop = 'prop_' . $type;
            $arr[$type] = DB::table($table . ' as ' . $type)
                ->select([
                    $type . '.id as property_value_id',
                    $type . '.value as property_value',
                    $type . '.sort as property_value_sort',
                    $type . '.catalog_product_id as catalog_product_id',
                    $type . '.catalog_property_id as property_id',
                    $type . '.catalog_property_unit_id as property_unit_id',
                    $prop . '.title as property_title',
                    'type.title as type_title',
                    'type.resource as type_resource',
                    'unit.title as unit_title',
                    'unit.national_symbol as unit_symbol',
                ])
                ->join('ax_catalog_property as ' . $prop, $prop . '.id', '=', $type . '.catalog_property_id')
                ->join('ax_catalog_property_type as type', 'type.id', '=', $prop . '.catalog_property_type_id')
                ->leftJoin('ax_catalog_property_unit as unit', 'unit.id', '=', $type . '.catalog_property_unit_id')
                ->where($type . '.catalog_product_id', $this->id);
            if (!$isHidden) {
                $arr[$type]->where(function ($query) use ($prop) {
                    $query->where($prop . '.is_hidden', 0)->orWhere($prop . '.is_hidden', null);
                });
            }

        }
        $all = $arr['text']->union($arr['int'])
            ->union($arr['double'])
            ->union($arr['varchar'])
            ->orderBy('property_value_sort')
            ->get();
        return count($all) ? $all : [];
    }

    protected function deleteWidgetTabs(): void
    {
        $this->widgetTabs?->delete();
    }

    protected function checkAliasAll(string $alias): bool
    {
        $id = $this->id;
        $post = self::query()->where('alias', $alias)->when($id, function ($query, $id) {
            $query->where('id', '!=', $id);
        })->first();
        if ($post) {
            return true;
        }
        return false;
    }
}
