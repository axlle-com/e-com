<?php

namespace App\Common\Models\Catalog\Document;

use App\Common\Models\Main\BaseModel;
use App\Common\Models\Main\EventSetter;
use App\Common\Models\Main\Status;
use App\Common\Models\Main\UserSetter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * This is the model class for table "{{%ax_document_coming}}".
 *
 * @property int $id
 * @property string $resource
 * @property int $resource_id
 * @property int|null $catalog_document_id
 * @property int|null $catalog_storage_place_id
 * @property int|null $currency_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 *
 * @property CatalogDocumentContent[] $contents
 */
class DocumentComing extends BaseModel implements Status
{
    use EventSetter, UserSetter;

    public string $key = 'coming';
    public string $contentClass;
    protected $table = 'ax_document_coming';

    public static function rules(string $type = 'create'): array
    {
        return [
                'create' => [
                    'id' => 'nullable|integer',
                    'catalog_document_subject_id' => 'required|integer',
                    'content' => 'required|array',
                    'content.*.catalog_product_id' => 'required|integer',
                    'content.*.price_in' => 'nullable|numeric',
                    'content.*.price_out' => 'nullable|numeric',
                    'content.*.quantity' => 'required|numeric|min:1',
                ],
                'posting' => [
                    'id' => 'required|integer',
                    'catalog_document_subject_id' => 'required|integer',
                    'content' => 'required|array',
                    'content.*.catalog_product_id' => 'required|integer',
                    'content.*.price_in' => 'nullable|numeric',
                    'content.*.price_out' => 'nullable|numeric',
                    'content.*.quantity' => 'required|numeric|min:1',
                ],
            ][$type] ?? [];
    }

    public static function createOrUpdate(array $post): self
    {
        if (empty($post['id']) || !$model = self::filter()->where(self::table('id'), $post['id'])
                ->first()) {
            $model = new self();
            $model->status = self::STATUS_NEW;
        }
        $model->catalog_document_subject_id = $post['catalog_document_subject_id'];
        $model->catalog_document_id = $post['catalog_document_id'] ?? null;
        $model->catalog_storage_place_id = $post['catalog_storage_place_id'] ?? null;
        $model->catalog_storage_place_id_target = $post['catalog_storage_place_id_target'] ?? null;
        $model->subject = $model->getSubject();
        if ($model->safe()->getErrors()) {
            return $model;
        }
        if (!empty($post['content'])) {
            if ($model->setContent($post['content'])) {
                return $model->load('contents'); # TODO: remake
            }
            return $model->setErrors(['catalog_document_content' => 'Произошли ошибки при записи']);
        }
        return $model->setErrors(['product' => 'Пустой массив']);
    }

    public function setContent(array $post): bool
    {
        $cont = [];
        $data = [];
        foreach ($post as $value) {
            $value['catalog_document_id'] = $this->id;
            $value['type'] = $this->subject->type_name ?? null;
            $value['subject'] = $this->subject->name ?? null;
            $content = CatalogDocumentContent::createOrUpdate($value);
            if ($content->getErrors()) {
                $cont[] = null;
            } else {
                $cont[] = $content;
            }
        }
        if (in_array(null, $cont, true)) {
            return false;
        }
        return true;
    }

    public function contents(): HasMany
    {
        return $this->hasMany(CatalogDocumentContent::class, 'catalog_document_id', 'id')
            ->select([
                CatalogDocumentContent::table('*'),
                'pr.title as product_title',
            ])
            ->join('ax_catalog_product as pr', 'pr.id', '=', CatalogDocumentContent::table('catalog_product_id'))
            ->orderBy(CatalogDocumentContent::table('created_at'), 'asc');
    }

    public function posting(): self
    {
        DB::beginTransaction();
        $errors = [];
        if ($this->getErrors()) {
            return $this;
        }
        if (($contents = $this->contents) && count($contents)) {
            foreach ($contents as $content) {
                $content->incoming_document_id = $this->catalog_document_id;
                if ($error = $content->posting($this->subject)->getErrors()) {
                    $errors[] = true;
                    $this->setErrors($error);
                }
            }
        }
        if ($errors) {
            DB::rollBack();
            return $this;
        }
        $this->status = self::STATUS_POST;
        if ($this->safe()->getErrors()) {
            DB::rollBack();
        } else {
            DB::commit();
        }
        return $this;
    }

    public static function deleteById(int $id)
    {
        $item = self::query()
            ->where('id', $id)
            ->where('status', '!=', self::STATUS_POST)
            ->first();
        if ($item) {
            return $item->delete();
        }
        return false;
    }
}
