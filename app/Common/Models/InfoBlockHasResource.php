<?php

namespace App\Common\Models;

use App\Common\Models\BaseModel;

/**
 * This is the model class for table "{{%info_block_has_resource}}".
 *
 * @property int $info_block_id
 * @property string $resource
 * @property int $resource_id
 *
 * @property InfoBlock $infoBlock
 */
class InfoBlockHasResource extends BaseModel
{
    protected $table = 'ax_info_block_has_resource';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [],
            ][$type] ?? [];
    }

    public function attributeLabels(): array
    {
        return [
            'info_block_id' => 'InfoBlock ID',
            'resource' => 'Resource',
            'resource_id' => 'Resource ID',
        ];
    }
    public function getInfoBlock()
    {
        return $this->hasOne(InfoBlock::class, ['id' => 'info_block_id']);
    }
}
