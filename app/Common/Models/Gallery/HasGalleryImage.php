<?php

namespace App\Common\Models\Gallery;

/**
 * @property string|null $image
 */
trait HasGalleryImage
{
    public function setImage(?string $image): static
    {
        if( !empty($image)) {
            $post['image'] = $image;
            $post['images_path'] = $this->setImagesPath();
            if($this->image) {
                unlink(public_path($this->image));
            }
            if($urlImage = GalleryImage::uploadSingleImage($post)) {
                $this->image = $urlImage;
            }
        }

        return $this;
    }


}
