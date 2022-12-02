<?php

namespace App\Common\Models\Main;

class BaseObserver
{
    public function created($model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }

    public function updated($model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }

    public function deleted($model): void
    {
        $model->setIpEvent(__FUNCTION__);
    }
}
