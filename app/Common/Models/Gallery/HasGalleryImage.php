<?php

namespace App\Common\Models\Gallery;

use App\Common\Models\Main\BaseModel;

/**
 * @property string|null $image
 */
trait HasGalleryImage
{

    public function setImage(array $post): static
    {
        $post['images_path'] = $this->setImagesPath();
        if ($this->image) {
            unlink(public_path($this->image));
        }
        if ($urlImage = GalleryImage::uploadSingleImage($post)) {
            $this->image = $urlImage;
        }
        return $this;
    }


}
