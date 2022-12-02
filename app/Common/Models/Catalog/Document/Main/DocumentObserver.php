<?php

namespace App\Common\Models\Catalog\Document\Main;

use App\Common\Models\Main\BaseObserver;

class DocumentObserver extends BaseObserver
{
    public function deleting($post): void
    {
        $post->deleteContent();
    }
}
