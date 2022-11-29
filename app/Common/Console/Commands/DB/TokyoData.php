<?php

namespace App\Common\Console\Commands\DB;

use App\Common\Models\Page\Page;
use App\Common\Models\Render;

class TokyoData extends FillData
{
    public function setRender(): static
    {
        $render = [
            ['Шаблон для страницы "Обо мне"', 'about', 'ax_page'],
            ['Шаблон для страницы "Услуги"', 'service', 'ax_post_category'],
            ['Шаблон для страницы "Услуга детально"', 'service', 'ax_post'],
            ['Шаблон для страницы "Контакты"', 'contact', 'ax_page'],
        ];
        $i = 1;
        foreach ($render as $value) {
            if (Render::query()->where('name', $value[1])->first()) {
                continue;
            }
            $model = new Render();
            $model->title = $value[0];
            $model->name = $value[1];
            $model->resource = $value[2];
            $model->safe();
            $i++;
        }
        echo 'Add ' . $i . ' Render' . PHP_EOL;
        return $this;
    }

    public function setAbout(): static
    {
        if (!$model = Page::query()->where('alias', 'about')->first()) {
            $model = new Render();
        }
        $model->title = 'Обо мне';
        $model->safe();
        echo 'Add setAbout' . PHP_EOL;
        return $this;
    }
}
