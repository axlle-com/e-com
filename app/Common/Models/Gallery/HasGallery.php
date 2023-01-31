<?php

namespace App\Common\Models\Gallery;

use App\Common\Models\Main\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * @property Collection<Gallery> $manyGallery
 * @property Collection<Gallery> $manyGalleryWithImages
 */
trait HasGallery
{
    public function manyGalleryWithImages(): BelongsToMany
    {
        /** @var $this BaseModel */
        return $this->belongsToMany(Gallery::class, 'ax_gallery_has_resource', 'resource_id', 'gallery_id')
            ->wherePivot('resource', '=', $this->getTable())
            ->with('images');
    }

    public function detachManyGallery(): static
    {
        /** @var $this BaseModel */
        DB::table('ax_gallery_has_resource')
            ->where('resource', $this->getTable())
            ->where('resource_id', $this->id)
            ->delete();

        return $this;
    }

    public function setGalleries(?array $post): static
    {
        /** @var $this BaseModel */
        if($this->isDirty()) {
            $this->safe();
        }
        $ids = [];
        foreach($post ?? [] as $gallery) {
            $gallery['title'] = $this->title ?? 'Undefined';
            $gallery['images_path'] = $this->setImagesPath();
            $inst = Gallery::createOrUpdate($gallery);
            if($errors = $inst->getErrors()) {
                $this->setErrors($errors);
            } else {
                $ids[$inst->id] = ['resource' => $this->getTable()];
            }
        }
        $this->manyGallery()->sync($ids);

        return $this;
    }

    public function manyGallery(): BelongsToMany
    {
        /** @var $this BaseModel */
        return $this->belongsToMany(Gallery::class, 'ax_gallery_has_resource', 'resource_id', 'gallery_id')
            ->wherePivot('resource', '=', $this->getTable());
    }
}
