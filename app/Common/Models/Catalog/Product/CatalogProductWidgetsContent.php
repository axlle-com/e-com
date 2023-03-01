<?php

namespace App\Common\Models\Catalog\Product;

use App\Common\Models\Catalog\BaseCatalog;
use App\Common\Models\Gallery\GalleryImage;
use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "{{%catalog_product_widgets_content}}".
 *
 * @property int $id
 * @property int $catalog_product_widgets_id
 * @property string $title
 * @property string $title_short
 * @property string|null $description
 * @property string|null $image
 * @property int|null $sort
 * @property int|null $show_image
 * @property string|null $media
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProductWidgets $widget
 */
class CatalogProductWidgetsContent extends BaseCatalog
{
    protected $table = 'ax_catalog_product_widgets_content';

    protected static function boot()
    {

        self::creating(static function($model) {});

        self::created(static function($model) {});

        self::updating(static function($model) {});

        self::updated(static function($model) {});

        self::deleting(static function($model) {});

        self::deleted(static function($model) {
            /** @var $model self */
            $model->widget->touch();
        });
        parent::boot();
    }

    public static function rules(string $type = 'create'): array
    {
        return [
            'create' => [],
            'delete' => [
                'id' => 'required|integer',
                'model' => 'required|string',
            ],
        ][$type] ?? [];
    }

    public static function createOrUpdate(array $post): static
    {
        $inst = [];
        $collection = new self();
        foreach($post['tabs'] as $item) {
            /** @var $model self */
            if(!(($id = $item['id'] ?? null) && ($model = self::query()->where('id', $id)->first()))) {
                $model = new self();
                $model->catalog_product_widgets_id = $post['catalog_product_widgets_id'];
            }
            $model->setTitle($item);
            if($title_short = $item['title_short'] ?? $item['title']) {
                $model->title_short = $title_short;
            }
            if($item['description'] ?? null) {
                $model->description = $item['description'];
            }
            if($item['sort'] ?? null) {
                $model->sort = $item['sort'];
            }
            if(isset($item['image'])) {
                $item['images_path'] = $post['images_path'];
                $model->image = GalleryImage::uploadSingleImage($item);
            }
            $model->sort = (int)$item['sort'];
            if($err = $model->safe()->getErrors()) {
                $collection->setErrors($err);
            } else {
                $inst[] = $model;
            }
        }
        return $collection->setCollection($inst);
    }

    public static function deleteAnyContent(array $data)
    {
        if(($model = BaseModel::className($data['model'])) && ($db = $model::find($data['id']))) {
            return $db->deleteContent();
        }
        return self::sendErrors();
    }

    public function deleteContent(): static
    {
        $this->deleteImage();
        if(!$this->getErrors()) {
            $this->delete();
            return $this;
        }
        return $this;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_product_widgets_id' => 'Catalog Product Widgets ID',
            'title' => 'Title',
            'title_short' => 'Title Short',
            'description' => 'Description',
            'image' => 'Image',
            'sort' => 'Sort',
            'show_image' => 'Show Image',
            'media' => 'Media',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function widget(): BelongsTo
    {
        return $this->belongsTo(CatalogProductWidgets::class, 'catalog_product_widgets_id', 'id');
    }
}
