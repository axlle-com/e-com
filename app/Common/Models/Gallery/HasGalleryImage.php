<?php

namespace App\Common\Models\Gallery;

use Exception;

/**
 * @property string|null $image
 */
trait HasGalleryImage
{
    public function setImage(?string $image): static
    {
        if(!empty($image)) {
            $post['image'] = $image;
            $post['images_path'] = $this->setImagesPath();
            if($this->image) {
                try {
                    unlink(public_path($this->image));
                } catch(Exception $exception) {
                }
            }
            if($urlImage = GalleryImage::uploadSingleImage($post)) {
                $this->image = $urlImage;
            }
        }

        return $this;
    }

    public function getImage(): string
    {
        $image = $this->image ?? null;
        if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443) {
            $ip = 'https://' . $_SERVER['SERVER_NAME'];
        } else {
            $ip = 'http://' . $_SERVER['SERVER_NAME'];
        }

        return $image ? $ip . $image : '';
    }


}
