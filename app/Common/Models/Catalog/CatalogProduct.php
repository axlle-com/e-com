<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;
use App\Common\Models\Gallery\Gallery;
use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Render;
use App\Common\Models\Wallet\Currency;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%catalog_product}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $category_title
 * @property string|null $category_title_short
 * @property int|null $render_id
 * @property int|null $gallery_id
 * @property string|null $render_title
 * @property int|null $is_published
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
 * @property CatalogBasket[] $catalogBaskets
 * @property CatalogDocumentContent[] $catalogDocumentContents
 * @property CatalogCategory $category
 * @property Render $render
 * @property CatalogProductHasCurrency[] $catalogProductHasCurrencies
 * @property Currency[] $currencies
 * @property CatalogProductWidgets[] $catalogProductWidgets
 * @property CatalogProductWidgets[] $catalogProductWidgetsWithContent
 * @property CatalogStorage[] $catalogStorages
 * @property CatalogStoragePlace[] $catalogStoragePlaces
 */
class CatalogProduct extends BaseModel
{
    protected $table = 'ax_catalog_product';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
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
                ],
            ][$type] ?? [];
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

    public function catalogBaskets(): HasMany
    {
        return $this->hasMany(CatalogBasket::class, 'product_id', 'id');
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
            ->with('catalogProductWidgetsContents');
    }

    public function catalogStorages(): HasMany
    {
        return $this->hasMany(CatalogStorage::className(), 'catalog_product_id', 'id');
    }

    public function getCatalogStoragePlaces()
    {
        return $this->hasMany(CatalogStoragePlace::className(), ['id' => 'catalog_storage_place_id'])->viaTable('{{%catalog_storage}}', ['catalog_product_id' => 'id']);
    }


    public function gallery(): BelongsToMany
    {
        return $this->belongsToMany(
            Gallery::class,
            'ax_gallery_has_resource',
            'resource_id',
            'gallery_id'
        );
    }

    public function galleryWithImages(): BelongsToMany
    {
        return $this->belongsToMany(
            Gallery::class,
            'ax_gallery_has_resource',
            'resource_id',
            'gallery_id'
        )->with('images');
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
        $model->setTitle($post);
        $model->setAlias($post);
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
            }
        }
        if (!empty($post['images'])) {
            $gallery = Gallery::createOrUpdate($post);
            if ($errors = $gallery->getErrors()) {
                $model->setErrors(['gallery' => $errors]);
            }else{
                $model->gallery()->sync([$gallery->id => ['resource' => $model->getTable()]]);
            }
        }
        if (!empty($post['tabs'])) {
            $productWidgets = CatalogProductWidgets::createOrUpdate($post);
            if ($errors = $productWidgets->getErrors()) {
                $model->setErrors(['widgets' => $errors]);
            }
        }
        return $model;
    }
}
