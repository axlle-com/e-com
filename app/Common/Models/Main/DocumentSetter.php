<?php

namespace App\Common\Models\Main;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * This is the BaseDocumentModel class.
 *
 * @property int|null $user_first_name
 * @property int|null $user_last_name
 * @property int|null $ip
 * @property int|null $fin_name
 * @property int|null $fin_title
 *
 */
trait DocumentSetter
{
    public ?BaseModel $contentClass;

    public function getContentClass(): BaseModel
    {
        if (empty($this->contentClass)) {
            $this->setContentClass();
        }
        return $this->contentClass;
    }

    public function setContentClass(): self
    {
        $string = (self::class) . 'Content';
        $this->contentClass = new $string();
        return $this;
    }

    public function setContent(?array $post): self
    {
        if (empty($post)) {
            return $this->setErrors(['content' => 'Документ не может быть пустым']);
        }
        $cont = [];
        foreach ($post as $value) {
            $value['catalog_document_id'] = $this->id;
            $value['type'] = $this->subject->type_name ?? null;
            $value['subject'] = $this->key ?? null;
            $content = $this->contentClass::createOrUpdate($value);
            if ($err = $content->getErrors()) {
                $cont[] = null;
                $this->setErrors($err);
            } else {
                $cont[] = $content;
            }
        }
        if (!in_array(null, $cont, true)) {
            $this->setContents(new Collection($cont));
        }
        return $this;
    }

    public function setContents(Collection $contents): self
    {
        $this->contents = $contents;
        return $this;
    }

    public function setDocument(?string $json): self
    {
        if (!empty($json)) {
            $document = json_decode($json, false);
            if ($document && !empty($document['model']) && !empty($document['model_id'])) {
                $this->document = $document['model'];
                $this->document_id = $document['model_id'];
            } else {
                $this->setErrors(['document' => 'Не удалось распознать документ основание']);
            }
        }
        return $this;
    }

    public function contents(): HasMany
    {
        return $this->hasMany($this->getContentClass()::class, $this->getContentClass()->getTable('document_id'), 'id')
            ->select([
                $this->getContentClass()::table('*'),
                'pr.title as product_title',
            ])
            ->join('ax_catalog_product as pr', 'pr.id', '=', $this->getContentClass()->getTable('catalog_product_id'))
            ->orderBy($this->getContentClass()->getTable('created_at'));
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
