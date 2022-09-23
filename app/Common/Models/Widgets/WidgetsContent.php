<?php

namespace App\Common\Models\Widgets;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%widgets_content}}".
 *
 * @property int $id
 * @property int $widgets_id
 * @property string $title
 * @property string|null $title_short
 * @property string|null $description
 * @property string|null $image
 * @property int|null $sort
 * @property int|null $show_image
 * @property string|null $media
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Widgets $widgets
 */
class WidgetsContent extends BaseModel
{
    protected $table = '{{%widgets_content}}';
}
