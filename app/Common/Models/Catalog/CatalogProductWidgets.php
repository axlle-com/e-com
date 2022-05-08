<?php

namespace App\Common\Models\Catalog;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Render;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is the model class for table "{{%catalog_product_widgets}}".
 *
 * @property int $id
 * @property int $catalog_product_id
 * @property int|null $render_id
 * @property string $name
 * @property string $title
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogProduct $catalogProduct
 * @property Render $render
 * @property CatalogProductWidgetsContent[] $content
 */
class CatalogProductWidgets extends BaseModel
{
    public const WIDGET_TABS = 'tabs';

    public static array $widgets = [
        self::WIDGET_TABS => self::WIDGET_TABS,
    ];
    protected $table = 'ax_catalog_product_widgets';

    public static function rules(string $type = 'create'): array
    {
        return [][$type] ?? [];
    }

    public static function boot()
    {

        self::creating(static function ($model) {
        });

        self::created(static function ($model) {
        });

        self::updating(static function ($model) {
            /* @var $model self */
            $model->checkForEmpty(); # TODO: пройтись по всем связям
        });

        self::updated(static function ($model) {
        });

        self::deleting(static function ($model) {
            $model->deleteContent();
        });

        self::deleted(static function ($model) {
        });
        parent::boot();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_product_id' => 'Catalog Product ID',
            'render_id' => 'Render ID',
            'name' => 'Name',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function catalogProduct(): BelongsTo
    {
        return $this->belongsTo(CatalogProduct::class, 'catalog_product_id', 'id');
    }

    public function render(): BelongsTo
    {
        return $this->belongsTo(Render::class, 'render_id', 'id');
    }

    public function content(): HasMany
    {
        return $this->hasMany(CatalogProductWidgetsContent::class, 'catalog_product_widgets_id', 'id')
            ->orderBy('sort')
            ->orderBy('created_at');
    }

    public function checkForEmpty(): void
    {
        if ($this->content->isEmpty()) {
            $this->delete();
        }
    }

    public function deleteContent(): void
    {
        $this->content()->delete();
    }

    public static function createOrUpdate(array $post, string $type = 'tabs'): static
    {
        if (empty($post['catalog_product_widgets_id']) || !$model = self::query()->where('id', $post['catalog_product_widgets_id'])->first()) {
            $model = new static();
        }
        $model->catalog_product_id = $post['catalog_product_id'];
        $model->title = $post['title'];
        $model->name = self::$widgets[$type];
        $model->safe();
        if ($model->getErrors()) {
            return $model;
        }
        if (!empty($post['tabs'])) {
            $post['catalog_product_widgets_id'] = $model->id;
            $post['images_path'] = $model->setImagesPath();
            $content = CatalogProductWidgetsContent::createOrUpdate($post);
            if ($errors = $content->getErrors()) {
                $model->setErrors(['content' => $errors]);
            } else {
                $model->content = $content->getCollection();
                $model->content->sortBy('sort');
            }
        }
        return $model;
    }

}
