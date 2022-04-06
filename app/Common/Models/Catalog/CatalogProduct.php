<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;
use App\Common\Models\Gallery;
use App\Common\Models\GalleryImage;
use App\Common\Models\Render;
use App\Common\Models\Wallet\Currency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%catalog_product}}".
 *
 * @property int $id
 * @property int|null $category_id
 * @property int|null $render_id
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
        if (empty($post['id']) || !$model = self::builder('gallery')->where(self::table() . '.id', $post['id'])->first()) {
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
        if (!empty($post['image'])) {
            if ($model->image) {
                unlink(public_path($model->image));
            }
            if ($urlImage = GalleryImage::uploadSingleImage($post)) {
                $model->image = $urlImage;
            }
        }
        if (!empty($post['images'])) {
            $post['gallery_id'] = $model->gallery_id;
            $post['title'] = $model->title;
            $gallery = Gallery::createOrUpdate($post);
            if ($errors = $gallery->getErrors()) {
                $model->setErrors(['gallery' => $errors]);
            }
        }
        unset($model->gallery_id);
        if ($model->safe()->getErrors()) {
            return $model;
        }
        if (!empty($post['tabs'])) {
            $post['catalog_product_id'] = $model->id;
            $post['title'] = $model->title;
            $productWidgets = CatalogProductWidgets::createOrUpdate($post);
            if ($errors = $productWidgets->getErrors()) {
                $model->setErrors(['gallery' => $errors]);
            }
        }
        $model->gallery()->sync([$gallery->id => ['resource' => $model->getTable()]]);
        return $model;
    }

    public static function builder(string $type = 'index'): Builder
    {
        $builder = self::query();
        switch ($type) {
            case 'category':
                $builder->select([
                    self::table() . '.*',
                    'par.title as category_title',
                    'par.title_short as category_title_short',
                    'ren.title as render_title',
                ])
                    ->leftJoin('ax_post_category as par', self::table() . '.category_id', '=', 'par.id')
                    ->leftJoin('ax_render as ren', self::table() . '.render_id', '=', 'ren.id');
                break;
            case 'gallery':
                $builder->select([
                    self::table() . '.*',
                    'ax_gallery.id as gallery_id',
                ])
                    ->leftJoin('ax_gallery_has_resource as has', 'has.resource_id', '=', self::table() . '.id')
                    ->where('has.resource', self::table())
                    ->leftJoin('ax_gallery', 'has.gallery_id', '=', 'ax_gallery.id');
                break;
            case 'gallery2':
                break;
        }
        return $builder;
    }

}
