<?php

namespace App\Common\Models\Main;

class BaseObserver
{
    public function created($post): void
    {
        $post->setIpEvent(__FUNCTION__);
    }

    public function updated($post): void
    {
        $post->setIpEvent(__FUNCTION__);
    }

    public function deleted($post): void
    {
        $post->setIpEvent(__FUNCTION__);
    }
}
