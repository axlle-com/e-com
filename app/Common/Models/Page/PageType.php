<?php

namespace App\Common\Models\Page;

use App\Common\Models\Main\BaseModel;

/**
 * This is the model class for table "{{%page_type}}".
 *
 * @property int $id
 * @property string $resource
 * @property string $title
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property Page[] $pages
 */
class PageType extends BaseModel
{
    protected $table = 'ax_page_type';

    public function getPages()
    {
        return $this->hasMany(Page::class, ['page_type_id' => 'id']);
    }
}
