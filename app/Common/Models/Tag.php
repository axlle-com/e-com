<?php

namespace App\Common\Models;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property int $id
 * @property int|null $is_sitemap
 * @property int|null $is_published
 * @property int|null $is_favourites
 * @property int|null $is_watermark
 * @property string|null $image
 * @property int|null $show_image
 * @property string $alias
 * @property string $title
 * @property string|null $title_short
 * @property string|null $description
 * @property string|null $title_seo
 * @property string|null $description_seo
 * @property int|null $sort
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property TagHasResource[] $tagsHasResources
 */
class Tag extends BaseModel
{
    protected $table = 'ax_tag';

    public static function rules(string $type = 'create'): array
    {
        return ['create' => [],][$type] ?? [];
    }
}
