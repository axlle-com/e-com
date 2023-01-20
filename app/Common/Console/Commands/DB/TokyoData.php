<?php

namespace App\Common\Console\Commands\DB;

use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\Setting\MainSetting;
use Throwable;

class TokyoData extends FillData
{
    public function setSetting(): static
    {
        $render = [
            [
                'field' => 'robots',
                'value' => '',
            ],
        ];
        $i = 1;
        foreach ($render as $value) {
            if (MainSetting::query()->where('name', $value[1])->first()) {
                continue;
            }
            $model = new MainSetting();
            $model->key = $value[0];
            $model->title = $value[1];
            $model->safe();
            $i++;
        }
        echo 'Add ' . $i . ' Render' . PHP_EOL;
        return $this;
    }

    public function setRender(): static
    {
        $render = [
            [
                'Шаблон для статичной страницы "Обо мне"',
                'about',
                'ax_page',
            ],
            [
                'Шаблон для статичной страницы "Главная"',
                'index',
                'ax_page',
            ],
            [
                'Шаблон для страницы "Услуги"',
                'service',
                'ax_post_category',
            ],
            [
                'Шаблон для страницы "Услуга детально"',
                'service',
                'ax_post',
            ],
            [
                'Шаблон для статичной страницы "Контакты"',
                'contact',
                'ax_page',
            ],
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

    /**
     * @throws Throwable
     */
    public function setPage(): static
    {
        $array = [
            'about' => [
                'title' => 'Обо мне',
            ],
            'contact' => [
                'title' => 'Контакты',
            ],
            'index' => [
                'title' => 'Главная',
            ],
        ];
        foreach ($array as $key => $page) {
            /** @var Render $render */
            $render = Render::query()->where('name', $key)->where('resource', Page::table())->first();
            if (!Page::query()->where('alias', $key)->first() && $render) {
                $page['alias'] = $key;
                $page['render_id'] = $render->id;
                $page['description'] = _view('render.' . $key)->renderSections()['content']();
                $model = Page::createOrUpdate($page);
                echo 'setPage: ' . $key . PHP_EOL;
            }
        }
        return $this;
    }

    public function setPostCategory(): static
    {
        $array = [
            'service' => [
                'title' => 'Услуги',
            ],
        ];

        foreach ($array as $key => $page) {
            /** @var Render $render */
            $render = Render::query()->where('name', $key)->where('resource', PostCategory::table())->first();
            if (!PostCategory::query()->where('alias', $key)->first() && $render) {
                $page['alias'] = $key;
                $page['render_id'] = $render->id;
                PostCategory::createOrUpdate($page);
                echo 'setPostCategory: ' . $key . PHP_EOL;
            }
        }
        return $this;
    }

    public function setAbout(): static
    {
        $array = [
            'service' => [
                'title' => 'Услуги',
            ],
        ];

        foreach ($array as $key => $page) {
            /** @var Render $render */
            $render = Render::query()->where('name', $key)->where('resource', PostCategory::table())->first();
            if (!PostCategory::query()->where('alias', $key)->first() && $render) {
                $page['alias'] = $key;
                $page['render_id'] = $render->id;
                PostCategory::createOrUpdate($page);
                echo 'setPostCategory: ' . $key . PHP_EOL;
            }
        }
        return $this;
    }
}
