<?php

use App\Common\Components\CurrencyParser;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Page\Page;
use App\Common\Models\Page\PageType;
use App\Common\Models\Render;
use App\Common\Models\Wallet\Currency as _Currency;
use App\Common\Models\Wallet\WalletCurrency;
use App\Common\Models\Wallet\WalletTransactionSubject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        ###### Шаблоны
        $this->setRender();
        ###### Типы страниц
        $this->setPageType();
        ###### Валюты
        $this->setCurrency();
        ###### Transaction
        $this->setWalletTransaction();
        ###### Страницы
        $this->setHistoryPage();
        $this->setPortfolio();
        $this->setContact();
        ###### Магазин
        $this->setCatalog();
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ax_page_type')->truncate();
        DB::table('ax_render')->truncate();
        DB::table('ax_currency_exchange_rate')->truncate();
        DB::table('ax_currency')->truncate();
        DB::table('ax_wallet_transaction_subject')->truncate();
        DB::table('ax_wallet_currency')->truncate();
        Schema::enableForeignKeyConstraints();
    }

    private function setRender(): void
    {
        $render = [
            ['Шаблон для страницы "История"', 'history', 'ax_page'],
            ['Шаблон для страницы "Портфолио"', 'portfolio', 'ax_page'],
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
        echo 'Add ' . $i . ' PageType' . PHP_EOL;
    }

    private function setPageType(): void
    {
        $type = [
            ['Входная страница блога', 'ax_post_category',],
            ['Входная страница магазина', 'ax_catalog_category',],
            ['Текстовая страница', 'ax_page',],
        ];
        $i = 1;
        foreach ($type as $value) {
            if (PageType::query()->where('resource', $value[1])->first()) {
                continue;
            }
            $model = new PageType();
            $model->title = $value[0];
            $model->resource = $value[1];
            $model->safe();
            $i++;
        }
        echo 'Add ' . $i . ' PageType' . PHP_EOL;
    }

    private function setCurrency(): void
    {
        if (!_Currency::query()->where('global_id', 'R00000')->first()) {
            $_model = new _Currency();
            $_model->global_id = 'R00000';
            $_model->num_code = 810;
            $_model->char_code = 'RUB';
            $_model->title = 'Российский рубль';
            $_model->save();
        }
        (new CurrencyParser())->setCurrencyPeriod(1);

        $currency = [
            'USD' => _Currency::query()->where('global_id', 'R01235')->first(),
            'RUB' => _Currency::query()->where('global_id', 'R00000')->first(),
        ];

        $cnt = 0;
        /* @var $item _Currency */
        foreach ($currency as $key => $item) {
            if (WalletCurrency::query()->where('name', $key)->where('currency_id', $item->id)->first()) {
                continue;
            }
            $model = new WalletCurrency();
            $model->name = $key;
            $model->title = $item->title;
            $model->currency_id = $item->id;
            if ($item->global_id === 'R00000') {
                $model->is_national = 1;
            } else {
                $model->is_national = 0;
            }
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' currency' . PHP_EOL;
    }

    private function setWalletTransaction(): void
    {
        $events = [
            'stock' => 'Покупка',
            'refund' => 'Возврат',
            'transfer' => 'Перевод',
        ];
        $types = [
            'debit' => 'Расход',
            'credit' => 'Приход',
        ];
        $cnt = 0;
        foreach ($events as $key => $event) {
            if (WalletTransactionSubject::query()->where('name', $key)->first()) {
                continue;
            }
            $model = new WalletTransactionSubject();
            $model->name = $key;
            $model->title = $event;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' events' . PHP_EOL;
    }

    private function setHistoryPage(): void
    {
        $desc = '
            <p class="history__paragraph">
                Привет, я Ира, и я делаю кухонные доски для Вас.
            </p>
            <p class="history__paragraph">
                Расскажу вам краткую историю как все началось.
            </p>
            <p class="history__paragraph">
                Возвращаясь после очередной поездки в горы, заряженные энергией природы, мы с супругом, как всегда,
                всю дорогу разговаривали, обсуждая наши планы и как их можно реализовать.
            </p>
            <p class="history__paragraph">
                В один момент говорю ему, я хочу что-то создавать! Создавать сама, создавать такое, чтоб нравилось мне, чтоб получала удовольствие от процесса, и чтобы это было нужно и полезно людям.
            </p>
            <p class="history__paragraph">
                На тот момент я даже не подозревала о своей любви к дереву, что смогу работать с таки не простым материалом, ведь это совсем не легкий труд и прямо скажем не для девочки.
            </p>
            <p class="history__paragraph">
                В это время я трудилась в компании, в чистом, комфортном офисе.
                Я понятия не имела что такого хочу создавать, но создавать я хотела это точно.
            </p>
            <p class="history__paragraph">
                Так произошло, что, приехав в гости к родителям, мы обнаружили у них в подвале доски из дуба, которые папа зачем-то туда положил много лет назад. И эти доски поехали к нам.
            </p>
            <p class="history__paragraph">
                Дело было перед новым годом, и мы решили из этого дуба сделать всем родным подарки в виде торцевых разделочных досок. Даже и не знаю почему мы это решили, наверное, судьба.
            </p>
            <p class="history__paragraph">
                Посмотрев кучу видео, как сие чудо делается, мы принялись за дело.
                И у нас получилось это самое чудо, не с первого раза конечно, но получилось.
            </p>
            <p class="history__paragraph">
                Родные были в восторге от таких подарков, не веря, что они сделаны нами. Но мы были убедительны.
            </p>
            <p class="history__paragraph">
                Мне настолько понравился процесс их создания, я была полностью захвачена им. Особенно моментом, после финального распила, когда бруски переворачиваются торцами вверх, происходит магия. Появляется рисунок, рисунок, который создала сама природа. Он прекрасен, и повторить его невозможно, от слова совсем. Наверное, в этот момент я обнаружила свою страсть и любовь к этому замечательному ремеслу.
            </p>
            <p class="history__paragraph">
                Так как у супруга нет времени мне помогать, и я взялась за дело сама.
            </p>
            <p class="history__paragraph">
                Выяснилось, что не получится совмещать работу с деревом и работу в офисе, мы приняли решение о моем увольнение, и я ушла с основного места работы в свободное плавание, в шумную, пыльную мастерскую.
            </p>
            <p class="history__paragraph">
                Так я начала делать торцевые разделочные доски.
            </p>
            <p class="history__paragraph">
                В один прекрасный момент, мне попалась широкая необрезная доска, отстрогав ее я увидела потрясающий рисунок дерева, решила его не распускать на брус, а отложить.
            </p>
            <p class="history__paragraph">
                Так пришла мысль сделать доску из массива.
            </p>
            <p class="history__paragraph">
                Изготовив несколько досок, захотелось добавить что-то, какую-то изюминку, вишенку на торте.
            </p>
            <p class="history__paragraph">
                Пришла идея нанести рисунок с помощью обычного советского выжигателя.
                Фокус не удался, мощность маловата, доска же из дуба.
            </p>
            <p class="history__paragraph">
                Так я приобрела себе профессиональный пирограф.
            </p>
            <p class="history__paragraph">
                С ним все получилось и понеслось. Хотелось выжигать на всех досках, а так как на торцевых такой возможности нет, я перешла на изделия из массива.
            </p>
            <p class="history__paragraph">
                Выпиливаю разные формы, подбираю к каждой рисунок, и получается вот такая уникальная доска, единственная в своем роде.
            </p>
            <p class="history__paragraph">
                Вот краткая история как я нашла себя в деревообработке.
            </p>
            <p class="history__paragraph">
                Все изделия, которые видите на сайте, сделано мной вручную. Я не пользуюсь современным оборудованием, которым управляет компьютер, станок с ЧПУ и лазер.
            </p>
            <p class="history__paragraph">
                Это говорит о том, что изделия не будут абсолютно одинаковыми.
            </p>
            <p class="history__paragraph">
                Форму доски подсказывает само дерево, рисунок наношу пирографом (возжигателем).
            </p>
            <p class="history__paragraph">
                В финишной обработке предпочитаю использовать только натуральные и безопасные материалы для человека и его здоровья.
                Всё, чего касаются продукты, должно быть безопасным.
            </p>
            <p class="history__paragraph">
                Я против тонирующих и красящих веществ на химической основе. Да, они придают красивые цвета и оттенки, но как по мне, это не безопасно.
            </p>
            <p class="history__paragraph">
                Все цвета изделий что вы видите, это натуральный цвет дерева.
            </p>
            <p class="history__paragraph">
                Как сказал мой коллега: «Я считаю, что истинное мастерство, функциональность и простота, которые воплощают в жизнь ремесленные изделия, являются наиболее важными аспектами деревообработки.»
            </p>
        ';

        $render = Render::query()->where('name', 'history')->where('resource', 'ax_page')->first();
        $pageType = PageType::query()->where('resource', 'ax_page')->first();

        $model = [
            'title' => 'История',
            'alias' => 'history',
            'description' => $desc,
            'page_type_id' => $pageType->id ?? null,
            'render_id' => $render->id ?? null,
            'user_id' => 6,
        ];
        $page = Page::createOrUpdate($model);
        if ($page->getErrors()) {
            echo json_encode($page->getErrors());
        } else {
            echo 'Add Page История' . PHP_EOL;
        }
    }

    private function setPortfolio(): void
    {
        $render = Render::query()->where('name', 'portfolio')->where('resource', 'ax_page')->first();
        $pageType = PageType::query()->where('resource', 'ax_page')->first();
        $model = [
            'title' => 'Портфолио',
            'alias' => 'portfolio',
            'page_type_id' => $pageType->id ?? null,
            'render_id' => $render->id ?? null,
            'user_id' => 6,
            'images_copy' => 1,
            'images' => [
                ['file' => public_path('/frontend/assets/img/IMG_4151_jpg.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4163.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4174.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4176.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4178.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4180.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4182.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4184.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4188.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4192.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4194.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4657.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4661.JPG')],
            ]
        ];
        $page = Page::createOrUpdate($model);
        if ($page->getErrors()) {
            echo $page->getErrorsString();
        } else {
            echo 'Add Page Портфолио' . PHP_EOL;
        }
    }

    private function setContact(): void
    {
        $render = Render::query()->where('name', 'contact')->where('resource', 'ax_page')->first();
        $pageType = PageType::query()->where('resource', 'ax_page')->first();

        $model = [
            'title' => 'Контакты',
            'alias' => 'contact',
            'page_type_id' => $pageType->id ?? null,
            'render_id' => $render->id ?? null,
            'user_id' => 6,
        ];
        $page = Page::createOrUpdate($model);
        if ($page->getErrors()) {
            echo $page->getErrorsString();
        } else {
            echo 'Add Page Контакты' . PHP_EOL;
        }
    }

    private function setCatalog(): void
    {
        $category = [
            'title' => 'Разделочные доски',
            'user_id' => 6,
        ];
        $model = [
            'title' => 'Разделочная доска',
            'user_id' => 6,
            'images_copy' => 1,
            'is_published' => 1,
            'image' => public_path('/frontend/assets/img/IMG_4151_jpg.JPG'),
            'images' => [
                ['file' => public_path('/frontend/assets/img/IMG_4151_jpg.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4163.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4174.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4176.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4178.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4180.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4182.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4184.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4188.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4192.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4194.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4657.JPG')],
                ['file' => public_path('/frontend/assets/img/IMG_4661.JPG')],
            ]
        ];
        $modelC = CatalogCategory::createOrUpdate($category);
        if ($modelC->getErrors()) {
            echo $modelC->getErrorsString();
        } else {
            echo 'Add Page Категория' . PHP_EOL;
            for ($i = 1; $i <= 5; $i++) {
                $model['title'] = 'Разделочная доска №' . $i;
                $model['category_id'] = $modelC->id;
                $modelP = CatalogProduct::createOrUpdate($model);
                if ($modelP->getErrors()) {
                    echo $modelP->getErrorsString();
                }
            }
        }
    }
};
