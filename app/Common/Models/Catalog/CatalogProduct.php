<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Catalog\Property\CatalogProductHasValueDecimal;
use App\Common\Models\Catalog\Property\CatalogProductHasValueInt;
use App\Common\Models\Catalog\Property\CatalogProductHasValueText;
use App\Common\Models\Catalog\Property\CatalogProductHasValueVarchar;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Main\BaseModel;
use App\Common\Models\Render;
use App\Common\Models\Wallet\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property int|null gallery_id
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
    protected $table = 'ax_catalog_product';

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
                    'tabs.*.title' => 'nullable|string',
                    'tabs.*.title_short' => 'nullable|string',
                    'tabs.*.description' => 'nullable|string',
                    'tabs.*.sort' => 'nullable|integer',
                ],
            ][$type] ?? [];
    }

    public static function boot()
    {
        self::creating(static function ($model) {
        });
        self::created(static function ($model) {
        });
        self::updating(static function ($model) {
        });
        self::updated(static function ($model) {
        });
        self::deleting(static function ($model) {
            /* @var $model self */
            $model->deleteImage();
            $model->detachManyGallery();
            $model->deleteCatalogProductWidgets();
//            $model->deleteComments(); # TODO: пройтись по всем связям и обернуть в транзакцию

        });
        self::deleted(static function ($model) {
        });
        parent::boot();
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'render_id' => 'Render ID',
            'is_published' => 'Is Published',
            'is_favourites' => 'Is Favourites',
            'is_comments' => 'Is Comments',
            'is_watermark' => 'Is Watermark',
            'media' => 'Media',
            'url' => 'Url',
            'alias' => 'Alias',
            'title' => 'Title',
            'price' => 'Price',
            'title_short' => 'Title Short',
            'preview_description' => 'Preview Description',
            'description' => 'Description',
            'title_seo' => 'Title Seo',
            'description_seo' => 'Description Seo',
            'show_date' => 'Show Date',
            'image' => 'Image',
            'hits' => 'Hits',
            'sort' => 'Sort',
            'stars' => 'Stars',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    protected function deleteCatalogProductWidgets(): void
    {
        $catalogProductWidgets = $this->catalogProductWidgets;
        foreach ($catalogProductWidgets as $widget) {
            $widget->delete();
        }
    }

    public function getCatalogProductHasValueDecimals()
    {
        return $this->hasMany(CatalogProductHasValueDecimal::class, ['catalog_product_id' => 'id']);
    }

    public function getCatalogProductHasValueInts()
    {
        return $this->hasMany(CatalogProductHasValueInt::class, ['catalog_product_id' => 'id']);
    }

    public function getCatalogProductHasValueTexts()
    {
        return $this->hasMany(CatalogProductHasValueText::class, ['catalog_product_id' => 'id']);
    }

    public function getCatalogProductHasValueVarchars()
    {
        return $this->hasMany(CatalogProductHasValueVarchar::class, ['catalog_product_id' => 'id']);
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

    public function getCurrencies()
    {
        return $this->hasMany(Currency::class, ['id' => 'currency_id'])->viaTable('{{%catalog_product_has_currency}}', ['catalog_product_id' => 'id']);
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

    public function getCatalogStoragePlaces()
    {
        return $this->hasMany(CatalogStoragePlace::class, ['id' => 'catalog_storage_place_id'])->viaTable('{{%catalog_storage}}', ['catalog_product_id' => 'id']);
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

    public function setPrice(array $post): self
    {
        if (!empty($post['price']) && !empty($post['price'][Currency::RUB])) {
            $this->price = round($post['price'][Currency::RUB], 2);
        }
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public static function createOrUpdate(array $post): static
    {
        /* @var $gallery Gallery */
        if (empty($post['id']) || !$model = self::builder()->_gallery()->where(self::table() . '.id', $post['id'])->first()) {
            $model = new self();
        }
        $model->category_id = $post['category_id'] ?? null;
        $model->render_id = $post['render_id'] ?? null;
        $model->is_published = empty($post['is_published']) ? 0 : 1;
        $model->is_favourites = empty($post['is_favourites']) ? 0 : 1;
        $model->is_watermark = empty($post['is_watermark']) ? 0 : 1;
        $model->is_comments = empty($post['is_comments']) ? 0 : 1;
        $model->title_short = $post['title_short'] ?? null;
        $model->description = $post['description'] ?? null;
        $model->preview_description = $post['preview_description'] ?? null;
        $model->title_seo = $post['title_seo'] ?? null;
        $model->description_seo = $post['description_seo'] ?? null;
        $model->sort = $post['sort'] ?? null;
        $model->setPrice($post);
        $model->setTitle($post);
        $model->setAlias($post);
        $model->createdAtSet($post['created_at'] ?? null);
        $model->url = $model->alias;
        $post['images_path'] = $model->setImagesPath();
        $post['gallery_id'] = $model->gallery_id;
        $post['title'] = $model->title;
        unset($model->gallery_id);
        if ($model->safe()->getErrors()) {
            return $model;
        }
        $post['catalog_product_id'] = $model->id;
        if (!empty($post['image'])) {
            if ($model->image) {
                unlink(public_path($model->image));
            }
            if ($urlImage = GalleryImage::uploadSingleImage($post)) {
                $model->image = $urlImage;
                $model->safe();
            }
        }
        if (!empty($post['images'])) {
            $gallery = Gallery::createOrUpdate($post);
            if ($errors = $gallery->getErrors()) {
                $model->setErrors(['gallery' => $errors]);
            } else {
                $model->manyGallery()->sync([$gallery->id => ['resource' => $model->getTable()]]);
            }
        }
        if (!empty($post['tabs'])) {
            $productWidgets = CatalogProductWidgets::createOrUpdate($post, 'tabs');
            if ($errors = $productWidgets->getErrors()) {
                $model->setErrors(['widgets' => $errors]);
            } else {
                $model->widgetTabs = $productWidgets;
            }
        }
        if (!empty($post['property'])) {
            $model->setProperty($post['property']);
        }
        return $model;
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

    public function getProperty()
    {
        $first0 = DB::table('ax_catalog_product_has_value_decimal as decimal')
            ->select([
                'decimal.value as value',
                'decimal.sort as sort',
                'decimal.catalog_product_id as catalog_product_id',
                'decimal.catalog_property_id as catalog_property_id',
                'decimal.catalog_property_unit_id as catalog_property_unit_id',
                'prop.title as property_title',
                'type.title as type_title',
                'type.resource as type_resource',
            ])
            ->join('ax_catalog_property as prop', 'prop.id', '=', 'decimal.catalog_property_id')
            ->join('ax_catalog_property_type as type', 'type.id', '=', 'prop.catalog_property_type_id')
            ->where('catalog_product_id', $this->id);
        $first1 = DB::table('ax_catalog_product_has_value_int as int')
            ->select([
                'int.value as value',
                'int.sort as sort',
                'int.catalog_product_id as catalog_product_id',
                'int.catalog_property_id as catalog_property_id',
                'int.catalog_property_unit_id as catalog_property_unit_id',
                'prop.title as property_title',
                'type.title as type_title',
                'type.resource as type_resource',
            ])
            ->join('ax_catalog_property as prop', 'prop.id', '=', 'int.catalog_property_id')
            ->join('ax_catalog_property_type as type', 'type.id', '=', 'prop.catalog_property_type_id')
            ->where('catalog_product_id', $this->id);
        $first2 = DB::table('ax_catalog_product_has_value_text as text')
            ->select([
                'text.value as value',
                'text.sort as sort',
                'text.catalog_product_id as catalog_product_id',
                'text.catalog_property_id as catalog_property_id',
                'text.catalog_property_unit_id as catalog_property_unit_id',
                'prop.title as property_title',
                'type.title as type_title',
                'type.resource as type_resource',
            ])
            ->join('ax_catalog_property as prop', 'prop.id', '=', 'text.catalog_property_id')
            ->join('ax_catalog_property_type as type', 'type.id', '=', 'prop.catalog_property_type_id')
            ->where('catalog_product_id', $this->id);
        $all = DB::table('ax_catalog_product_has_value_varchar as varchar')
            ->select([
                'varchar.value as value',
                'varchar.sort as sort',
                'varchar.catalog_product_id as catalog_product_id',
                'varchar.catalog_property_id as catalog_property_id',
                'varchar.catalog_property_unit_id as catalog_property_unit_id',
                'prop.title as property_title',
                'type.title as type_title',
                'type.resource as type_resource',
            ])
            ->join('ax_catalog_property as prop', 'prop.id', '=', 'varchar.catalog_property_id')
            ->join('ax_catalog_property_type as type', 'type.id', '=', 'prop.catalog_property_type_id')
            ->where('catalog_product_id', $this->id)
            ->union($first0)
            ->union($first1)
            ->union($first2)
            ->get();
        _dd($all);
    }
}
