<?php

namespace App\Common\Console\Commands\DB;

use App\Common\Models\Blog\Post;
use App\Common\Models\Blog\PostCategory;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\Setting\MainSetting;
use App\Common\Models\Url\MainUrl;
use App\Common\Models\User\User;
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
        foreach($render as $value) {
            if(MainSetting::query()->where('name', $value[1])->first()) {
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
                'Шаблон для страницы "Услуги"',
                'service',
                'ax_page',
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
        foreach($render as $value) {
            if(Render::query()->where('name', $value[1])->first()) {
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
        foreach($array as $key => $page) {
            /** @var Render $render */
            $render = Render::query()->where('name', $key)->where('resource', Page::table())->first();
            if(!Page::withUrl()->where(MainUrl::table('alias'), $key)->first() && $render) {
                $page['alias'] = $key;
                $page['render_id'] = $render->id;
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
                'title' => 'Уголовно-правовая практика',
            ],
        ];

        foreach($array as $key => $page) {
            /** @var Render $render */
            $render = Render::query()->where('name', $key)->where('resource', PostCategory::table())->first();
            if(!PostCategory::withUrl()->where(MainUrl::table('alias'), $key)->first()) {
                $page['user_id'] = User::query()->first()->id;
                $page['render_id'] = $render->id ?? null;
                $page['alias'] = $key;
                PostCategory::createOrUpdate($page);
                echo 'setPostCategory: ' . $key . PHP_EOL;
            }
        }

        return $this;
    }

    public function setPost(): static
    {
        $array = [
            [
                'user_id' => 6,
                'category_id' => 1,
                'title' => 'Защита',
                'title_short' => 'Защита',
                'preview_description' => 'Осуществление защиты подозреваемых и обвиняемых…',
                'description' => '<p>Осуществление защиты подозреваемых и обвиняемых по делам о преступлениях:</p>
                                    <ul>
                                        <li>должностных (превышение/злоупотребление полномочиями, получение/дача взятки);</li>
                                        <li>в сфере экономической деятельности (незаконное предпринимательство, незаконная банковская деятельность, легализация денежных средств, преднамеренное/фиктивное банкротство, уклонение от уплаты налогов;</li>
                                        <li>против интересов службы в коммерческих и иных организациях (злоупотребление полномочиями, коммерческий подкуп);</li>
                                        <li>против собственности (мошенничество, присвоение/растрата, вымогательство).</li>
                                    </ul>',
            ],
            [
                'user_id' => 6,
                'category_id' => 1,
                'title' => 'Представительство',
                'title_short' => 'Представительство',
                'preview_description' => 'Представление интересов потерпевших и свидетелей на следствии и в суде…',
                'description' => '<p>Представление интересов потерпевших и свидетелей (физических и юридических лиц) на стадиях:</p>
                                    <ul>
                                        <li>проверки сообщения о преступлении (дача объяснений, предоставление документации по запросам правоохранительных органов);</li>
                                        <li>предварительного расследования (участие в обыске, допросе, очной ставке, подготовка ходатайств и жалоб);</li>
                                        <li>рассмотрения дела в суде (участие в судебном заседании, подготовка ходатайств, жалоб).</li>
                                    </ul>',
            ],
            [
                'user_id' => 6,
                'category_id' => 1,
                'title' => 'Консалтинг',
                'title_short' => 'Консалтинг',
                'preview_description' => 'Консультирование по вопросам уголовно-правовых рисков, адвокатское расследование, тренинги уголовно-правовой грамотности…',
                'description' => '<ul>
                                    <li>Уголовно-правовая оценка рисков привлечения к уголовной ответственности;</li>
                                    <li>Урегулирование бизнес-конфликтов;</li>
                                    <li>Адвокатское расследование;</li>
                                    <li>Тренинги уголовно-правовой грамотности для собственников бизнеса, руководителей и сотрудников коммерческих организаций, государственных и муниципальных служащих (подготовка к участию в проверочных и следственных действиях, проводимых правоохранительными органами).</li>
                                </ul>',
            ],
            [
                'user_id' => 6,
                'category_id' => 1,
                'title' => 'Страховка',
                'title_short' => 'Страховка',
                'preview_description' => 'Предварительное соглашение на случай допроса/обыска…',
                'description' => '<p>Если Вас вызывают на допрос или  в офис/квартиру пришли с обыском – Вы сообщаете о наличии соглашения на защиту с адвокатом.</p>
                                    <p>Это позволит:</p>
                                    <ul>
                                        <li>поручить общение с правоохранителями своему адвокату;</li>
                                        <li>подготовиться к общению с правоохранителями;</li>
                                        <li>перенести допрос на другой день/время;</li>
                                        <li>отложить начало обыска, до приезда адвоката.</li>
                                    </ul>',
            ],
            [
                'user_id' => 6,
                'category_id' => 1,
                'title' => 'Тренинги',
                'title_short' => 'Тренинги',
                'preview_description' => 'Тренинги уголовно-правовой грамотности для собственников бизнеса и сотрудников компаний…',
                'description' => '<p>Подготовка к участию в проверочных и следственных действиях, проводимых правоохранительными органами.</p>
                                    <h3>Для собственников бизнеса, руководителей и сотрудников компаний:</h3>
                                    <ul>
                                        <ol>Обыск. Когда и как часто приходят.</ol>
                                        <ol>Права и обязанности представителей компании и сотрудников правоохранительных органов.</ol>
                                        <ol>Кто, как и что ищет во время обыска. Что заберут, можно ли это вернуть.</ol>
                                        <ol>Допрос: права и обязанности до, во время, после.</ol>
                                        <ol>Как избежать конфликтной ситуации.</ol>
                                        <ol>Нарушения во время обыска и допроса. Как их использовать в своих интересах.</ol>
                                        <ol>Как, когда и куда эффективно жаловаться.</ol>
                                    </ul>
                                    <h3>Для собственников бизнеса и руководителей компаний:</h3>
                                    <ul>
                                        <ol>Уголовно-правовые риски бизнеса (кража, мошенничество, присвоение/растрата, банкротство, незаконное предпринимательство, налоговые и коррупционные преступления и др.).</ol>
                                        <ol>Источники возникновения.</ol>
                                        <ol>Последствия.</ol>
                                        <ol>Способы защиты компании.</ol>
                                    </ul>',
            ],
            [
                'user_id' => 6,
                'category_id' => 1,
                'title' => 'Чек-лист «Защита»',
                'title_short' => 'Чек-лист «Защита»',
                'preview_description' => 'Практические рекомендации о том, что делать, при общении с правоохранителями…',
                'description' => '<p>Если рядом нет адвоката, важно знать, что делать, когда правоохранители:</p>
                                    <ul>
                                        <li>требуют предоставить информацию/документы;</li>
                                        <li>хотят допросить;</li>
                                        <li>пришли с обыском;</li>
                                        <li>хотят задержать.</li>
                                    </ul>
                                    <p>Чек-лист – это Ваше спокойствие и консультация «до».</p>',
            ],
        ];

        foreach($array as $page) {
            $page['user_id'] = User::query()->first()->id;
            Post::createOrUpdate($page);
            echo 'setPostCategory: ' . PHP_EOL;
        }
        return $this;
    }
}
