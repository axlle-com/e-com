<?php

use App\Common\Components\CurrencyParser;
use App\Common\Components\UnitsParser;
use App\Common\Models\Catalog\CatalogCategory;
use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogDocumentSubject;
use App\Common\Models\Catalog\CatalogPaymentType;
use App\Common\Models\Catalog\CatalogProduct;
use App\Common\Models\Catalog\CatalogStoragePlace;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyType;
use App\Common\Models\Catalog\Property\CatalogPropertyUnit;
use App\Common\Models\FinTransactionType;
use App\Common\Models\Page\Page;
use App\Common\Models\Page\PageType;
use App\Common\Models\Render;
use App\Common\Models\UnitOkei;
use App\Common\Models\User\AddressType;
use App\Common\Models\Wallet\Currency;
use App\Common\Models\Wallet\Currency as _Currency;
use App\Common\Models\Wallet\WalletCurrency;
use App\Common\Models\Wallet\WalletTransactionSubject;
use App\Common\Models\Widgets\WidgetsPropertyType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        ###### Шаблоны
        $this->setRender();
        ###### Типы страниц
        $this->setPageType();
        ###### Типы операций
        $this->setFinType();
        ###### Валюты
        $this->setCurrency();
        ###### Виды операций
        $this->setWalletTransaction();
        ###### Страницы
        $this->setHistoryPage();
        $this->setPortfolio();
        $this->setContact();
        ###### Магазин
        $this->setCatalog();
        ###### Типы свойств
        $this->setCatalogPropertyType();
        ###### Типы свойств Widget
        $this->setWidgetsPropertyType();
        ###### Типы Address
        $this->setAddressType();
        ###### Типы Payment
        $this->setCatalogPaymentType();
        ###### Типы Delivery
        $this->setCatalogDeliveryType();
        ###### Виды документов
        $this->setCatalogDocumentSubject();
        ###### Склады
        $this->setCatalogStoragePlace();
        ###### Единицы
        $this->setUnitsParser();
        ###### Свойства
        $this->setCatalogProperty();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('ax_page_type')->truncate();
        DB::table('ax_page')->truncate();
        DB::table('ax_render')->truncate();
        DB::table('ax_currency_exchange_rate')->truncate();
        DB::table('ax_currency')->truncate();
        DB::table('ax_wallet_transaction_subject')->truncate();
        DB::table('ax_wallet_currency')->truncate();
        DB::table('ax_fin_transaction_type')->truncate();
        DB::table('ax_catalog_document_subject')->truncate();
        DB::table('ax_catalog_category')->truncate();
        DB::table('ax_catalog_product')->truncate();
        DB::table('ax_catalog_property_type')->truncate();
        DB::table('ax_widgets_property_type')->truncate();
        DB::table('ax_address_type')->truncate();
        DB::table('ax_catalog_payment_type')->truncate();
        DB::table('ax_catalog_delivery_type')->truncate();
        DB::table('ax_catalog_storage_place')->truncate();
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

    private function setFinType(): void
    {
        $types = [
            'debit' => 'Расход',
            'credit' => 'Приход',
        ];
        $cnt = 0;
        foreach ($types as $key => $event) {
            if (FinTransactionType::query()->where('name', $key)->first()) {
                continue;
            }
            $model = new FinTransactionType();
            $model->name = $key;
            $model->title = $event;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' Fin Type' . PHP_EOL;
    }

    private function setWalletTransaction(): void
    {
        $events = [
            'stock' => ['Покупка', 'debit'],
            'refund' => ['Возврат', 'credit'],
            'transfer' => ['Перевод', 'debit'],
        ];
        $types = FinTransactionType::all();
        $cnt = 0;
        foreach ($events as $key => $event) {
            if (WalletTransactionSubject::query()->where('name', $key)->first()) {
                continue;
            }
            $model = new WalletTransactionSubject();
            $model->name = $key;
            $model->title = $event[0];
            $model->fin_transaction_type_id = $types->where('name', $event[1])->first()->id;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' Wallet Subject' . PHP_EOL;
    }

    private function setCatalogDocumentSubject(): void
    {
        $events = [
            'sale' => ['Продажа', 'debit'],
            'refund' => ['Возврат', 'credit'],
            'coming' => ['Приход', 'credit'],
        ];
        $types = FinTransactionType::all();
        $cnt = 0;
        foreach ($events as $key => $event) {
            if (CatalogDocumentSubject::query()->where('name', $key)->first()) {
                continue;
            }
            $model = new CatalogDocumentSubject();
            $model->name = $key;
            $model->title = $event[0];
            $model->fin_transaction_type_id = $types->where('name', $event[1])->first()->id;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' Document Subject' . PHP_EOL;
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
            'description' => 'Таким образом сложившаяся структура организации представляет собой интересный эксперимент проверки позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же консультация с широким активом влечет за собой процесс внедрения и модернизации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же начало повседневной работы по формированию позиции играет важную роль в формировании направлений прогрессивного развития.',
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
            echo 'Add Page Category Product' . PHP_EOL;
            for ($i = 1; $i < 3; $i++) {
                $model['title'] = 'Разделочная доска №' . $i;
                $model['category_id'] = $modelC->id;
                $model['price'][Currency::RUB] = 2000.00;
                $modelP = CatalogProduct::createOrUpdate($model);
                if ($modelP->getErrors()) {
                    echo $modelP->getErrorsString();
                }
                echo 'Add Page Product' . PHP_EOL;
            }
        }
    }

    private function setCatalogPropertyType(): void
    {
        $models = [
            [
                'title' => 'Строка',
                'resource' => 'ax_catalog_product_has_value_varchar',
                'sort' => 0,
            ],
            [
                'title' => 'Ссылка',
                'resource' => 'ax_catalog_product_has_value_varchar',
                'sort' => 6,
            ],
            [
                'title' => 'Число',
                'resource' => 'ax_catalog_product_has_value_int',
                'sort' => 1,
            ],
            [
                'title' => 'Дробное число 0.00',
                'resource' => 'ax_catalog_product_has_value_decimal',
                'sort' => 2,
            ],
            [
                'title' => 'Большой текст',
                'resource' => 'ax_catalog_product_has_value_text',
                'sort' => 3,
            ],
            [
                'title' => 'Файл',
                'resource' => 'ax_catalog_product_has_value_varchar',
                'sort' => 5,
            ],
            [
                'title' => 'Изображение',
                'resource' => 'ax_catalog_product_has_value_varchar',
                'sort' => 4,
            ],
        ];
        foreach ($models as $post) {
            if (CatalogPropertyType::query()->where('title', $post['title'])->first()) {
                continue;
            }
            $model = new CatalogPropertyType();
            $model->title = $post['title'];
            $model->resource = $post['resource'];
            $model->sort = $post['sort'];
            $model->save();
        }
    }

    private function setWidgetsPropertyType(): void
    {
        $models = [
            [
                'title' => 'Строка',
                'resource' => 'ax_widgets_has_value_varchar',
                'sort' => 0,
            ],
            [
                'title' => 'Ссылка',
                'resource' => 'ax_widgets_has_value_varchar',
                'sort' => 6,
            ],
            [
                'title' => 'Число',
                'resource' => 'ax_widgets_has_value_int',
                'sort' => 1,
            ],
            [
                'title' => 'Дробное число 0.00',
                'resource' => 'ax_widgets_has_value_decimal',
                'sort' => 2,
            ],
            [
                'title' => 'Большой текст',
                'resource' => 'ax_widgets_has_value_text',
                'sort' => 3,
            ],
            [
                'title' => 'Файл',
                'resource' => 'ax_widgets_has_value_varchar',
                'sort' => 5,
            ],
            [
                'title' => 'Изображение',
                'resource' => 'ax_widgets_has_value_varchar',
                'sort' => 4,
            ],
        ];
        foreach ($models as $post) {
            if (WidgetsPropertyType::query()->where('title', $post['title'])->first()) {
                continue;
            }
            $model = new WidgetsPropertyType();
            $model->title = $post['title'];
            $model->resource = $post['resource'];
            $model->sort = $post['sort'];
            $model->save();
        }
    }

    private function setAddressType(): void
    {
        $models = [
            [
                'title' => 'Юридический Адрес',
            ],
            [
                'title' => 'Фактический адрес',
            ],
        ];
        foreach ($models as $post) {
            if (AddressType::query()->where('title', $post['title'])->first()) {
                continue;
            }
            $model = new AddressType();
            $model->title = $post['title'];
            $model->setAlias();
            $model->save();
        }
    }

    private function setCatalogPaymentType(): void
    {
        $models = [
            [
                'title' => 'Банковской картой',
                'is_active' => 1,
            ],
            [
                'title' => 'Электронными деньгами',
                'is_active' => 0,
            ],
            [
                'title' => 'Переводом через интернет-банк',
                'is_active' => 0,
            ],
        ];
        foreach ($models as $post) {
            if (CatalogPaymentType::query()->where('title', $post['title'])->first()) {
                continue;
            }
            $model = new CatalogPaymentType();
            $model->title = $post['title'];
            $model->is_active = $post['is_active'];
            $model->setAlias();
            $model->save();
        }
    }

    private function setCatalogDeliveryType(): void
    {
        $models = [
            [
                'title' => 'Служба доставки СДЭК',
                'is_active' => 1,
            ],
            [
                'title' => 'Курьером по городу',
                'is_active' => 1,
            ],
            [
                'title' => 'Почта Россия',
                'is_active' => 1,
            ],
        ];
        foreach ($models as $post) {
            if (CatalogDeliveryType::query()->where('title', $post['title'])->first()) {
                continue;
            }
            $model = new CatalogDeliveryType();
            $model->title = $post['title'];
            $model->is_active = $post['is_active'];
            $model->setAlias();
            $model->save();
        }
    }

    private function setCatalogStoragePlace(): void
    {
        $models = [
            [
                'title' => 'Главный склад',
                'is_place' => 1,
            ],
        ];
        foreach ($models as $post) {
            if (CatalogStoragePlace::query()->where('title', $post['title'])->first()) {
                continue;
            }
            $model = new CatalogStoragePlace();
            $model->title = $post['title'];
            $model->is_place = $post['is_place'];
            $model->save();
        }
    }

    private function setUnitsParser(): void
    {
        (new UnitsParser)->parse();

        $arr = [
            'Миллиметр',
            'Сантиметр',
            'Метр',
            'Грамм',
            'Килограмм',
            'Квадратный миллиметр',
            'Квадратный сантиметр',
            'Квадратный метр',
            'Набор',
            'Пара (2 шт.)',
            'Элемент',
            'Упаковка',
            'Штука',
        ];
        foreach ($arr as $item) {
            /* @var $un UnitOkei */
            if (($un = UnitOkei::query()->where('title', $item)->first()) && !CatalogPropertyUnit::query()->where('unit_okei_id', $un->id)->first()) {
                $model = new CatalogPropertyUnit;
                $model->title = $un->title;
                $model->national_symbol = $un->national_symbol;
                $model->international_symbol = $un->international_symbol;
                $model->unit_okei_id = $un->id;
                echo $model->safe()->getErrorsString();
            }
        }
    }

    private function setCatalogProperty(): void
    {
        $models = [
            [
                'title' => 'Материал',
                'type' => 'Строка',
            ],
            [
                'title' => 'Цвет',
                'type' => 'Строка',
            ],
            [
                'title' => 'Толщина',
                'type' => 'Число',
                'unit' => 'мм',
            ],
            [
                'title' => 'Ширина',
                'type' => 'Число',
                'unit' => 'мм',
            ],
            [
                'title' => 'Длина',
                'type' => 'Число',
                'unit' => 'мм',
            ],
            [
                'title' => 'Вес',
                'type' => 'Число',
                'unit' => 'г',
            ],
        ];
        $types = CatalogPropertyType::all();
        $units = CatalogPropertyUnit::all();
        foreach ($models as $post) {
            if (CatalogProperty::query()->where('title', $post['title'])->first()) {
                continue;
            }
            $model = new CatalogProperty();
            $model->title = $post['title'];
            $model->catalog_property_type_id = $types->where('title', $post['type'])->first()->id;
            $model->save();
            if (isset($post['unit'])) {
                $unit = $units->where('national_symbol', $post['unit'])->first();
                $model->units()->sync($unit);
            }
        }
    }
};
