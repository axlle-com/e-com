<?php

namespace App\Common\Models\Main;

class BaseObserver
{
    public function created($model): void
    {
        $model->setHistory(__FUNCTION__);
    }

    public function updated($model): void
    {
        $model->setHistory(__FUNCTION__);
    }

    public function deleted($model): void
    {
        $model->setHistory(__FUNCTION__);
    }
}
