<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\BaseModel;
use App\Common\Models\Gallery\GalleryImage;
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
 * @property CatalogProductWidgets $catalogProductWidgets
 */
class CatalogProductWidgetsContent extends BaseModel
{
    protected $table = 'ax_catalog_product_widgets_content';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
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

    public function catalogProductWidgets(): BelongsTo
    {
        return $this->belongsTo(CatalogProductWidgets::class, 'catalog_product_widgets_id', 'id');
    }

    public static function createOrUpdate(array $post): static
    {
        $errors = [];
        foreach ($post['tabs'] as $item) {
            /* @var $model self */
            if (!(($id = $item['id'] ?? null) && ($model = self::query()->where('id', $id)->first()))) {
                $model = new self();
                $model->catalog_product_widgets_id = $post['catalog_product_widgets_id'];
            }
            $model->setTitle($item);
            if ($title_short = $item['title_short'] ?? $item['title']) {
                $model->title_short = $title_short;
            }
            if ($item['description'] ?? null) {
                $model->description = $item['description'];
            }
            if ($item['sort'] ?? null) {
                $model->sort = $item['sort'];
            }
            if (isset($item['image'])) {
                $item['images_path'] = $post['images_path'];
                $model->image = GalleryImage::uploadSingleImage($item);
            }
            $model->sort = (int)$item['sort'];
            if ($err = $model->safe()->getErrors()) {
                $errors[] = $err;
            }
        }
        return self::sendErrors($errors);
    }
}
