<?php

namespace App\Common\Models\Main;

use App\Common\Models\Errors\_Errors;
use App\Common\Models\Gallery\GalleryImage;
use Exception;

/**
 * @property string|null $image
 */
trait HasImage
{
    public function setImage(array $post): static
    {
        /** @var $this BaseModel */
        $post['images_path'] = $this->setImagesPath();
        if ($this->image && file_exists(public_path($this->image))) {
            unlink(public_path($this->image));
        }
        if ($urlImage = GalleryImage::uploadSingleImage($post)) {
            $this->image = $urlImage;
        }
        return $this;
    }

    public function deleteImage(): static
    {
        /** @var $this BaseModel */
        if (!$this->deleteImageFile()->getErrors()) {
            return $this->safe();
        }
        return $this;
    }

    public function deleteImageFile(): static
    {
        /** @var $this BaseModel */
        if ($this->image ?? null) {
            try {
                if (file_exists(public_path($this->image))) {
                    unlink(public_path($this->image));
                }
                $this->image = null;
            } catch (Exception $exception) {
                $this->setErrors(_Errors::exception($exception, $this));
            }
        }
        return $this;
    }
}
