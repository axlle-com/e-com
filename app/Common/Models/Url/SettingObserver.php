<?php

namespace App\Common\Models\Setting;

use App\Common\Models\Main\BaseObserver;

class SettingObserver extends BaseObserver
{
    public function created($model): void
    {
        /** @var Setting $model */
        parent::created($model);
        $model->setCache();
    }

    public function updated($model): void
    {
        /** @var Setting $model */
        parent::updated($model);
        $model->setCache();
    }

    public function deleted($model): void
    {
        /** @var Setting $model */
        parent::deleted($model);
        $model->setCache();
    }
}
