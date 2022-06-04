<?php

namespace App\Common\Models\Main;

use App\Common\Models\Seo;

/**
 * @property string|null $title_seo
 * @property string|null $description_seo
 */
trait SeoTrait
{
    public string $title_seo;
    public string $description_seo;

    public function setSeo(array $post): static
    {
        /* @var $this BaseModel */
        $post['title'] = $post['title'] ?? null;
        $post['description'] = $post['description'] ?? null;
        $seo = Seo::createOrUpdate($post, $this);
        return $this;
    }
}
