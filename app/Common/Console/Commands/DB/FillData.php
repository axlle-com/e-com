<?php

namespace App\Common\Console\Commands\DB;

use App\Common\Components\CurrencyParser;
use App\Common\Components\UnitsParser;
use App\Common\Models\Catalog\CatalogDeliveryStatus;
use App\Common\Models\Catalog\CatalogDeliveryType;
use App\Common\Models\Catalog\CatalogPaymentStatus;
use App\Common\Models\Catalog\CatalogPaymentType;
use App\Common\Models\Catalog\Category\CatalogCategory;
use App\Common\Models\Catalog\FinTransactionType;
use App\Common\Models\Catalog\Product\CatalogProduct;
use App\Common\Models\Catalog\Property\CatalogProperty;
use App\Common\Models\Catalog\Property\CatalogPropertyType;
use App\Common\Models\Catalog\Property\CatalogPropertyUnit;
use App\Common\Models\Catalog\Storage\CatalogStoragePlace;
use App\Common\Models\Catalog\UnitOkei;
use App\Common\Models\Main\BaseComponent;
use App\Common\Models\Page\Page;
use App\Common\Models\Render;
use App\Common\Models\User\Counterparty;
use App\Common\Models\Wallet\Currency as _Currency;
use App\Common\Models\Wallet\WalletCurrency;
use App\Common\Models\Wallet\WalletTransactionSubject;
use App\Common\Models\Widgets\WidgetsPropertyType;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;


class FillData extends BaseComponent
{
    public function setRender(): static
    {
        $render = [
            [
                'Шаблон для страницы "История"',
                'history',
                'ax_page',
            ],
            [
                'Шаблон для страницы "Портфолио"',
                'portfolio',
                'ax_page',
            ],
            [
                'Шаблон для страницы "Контакты"',
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
        echo 'Add ' . $i . ' PageType' . PHP_EOL;
        return $this;
    }

    public function setCurrency(): static
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
        return $this;
    }

    public function setFinType(): static
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
        return $this;
    }

    public function setWalletTransaction(): static
    {
        $events = [
            'stock' => [
                'Покупка',
                'debit',
            ],
            'refund' => [
                'Возврат',
                'credit',
            ],
            'transfer' => [
                'Перевод',
                'debit',
            ],
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
        return $this;
    }

    public function setHistoryPage(): static
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

        $model = [
            'title' => 'История',
            'alias' => 'history',
            'description' => $desc,
            'render_id' => $render->id ?? null,
            'user_id' => 6,
        ];
        $page = Page::createOrUpdate($model);
        if ($page->getErrors()) {
            echo json_encode($page->getErrors());
        } else {
            echo 'Add Page История' . PHP_EOL;
        }
        return $this;
    }

    public function setPortfolio(): static
    {
        $render = Render::query()->where('name', 'portfolio')->where('resource', 'ax_page')->first();
        $model = [
            'title' => 'Портфолио',
            'alias' => 'portfolio',
            'render_id' => $render->id ?? null,
            'user_id' => 6,
            'galleries' => [
                [
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
                    ],
                ],
            ],
        ];
        $page = Page::createOrUpdate($model);
        if ($page->getErrors()) {
            echo $page->getErrorsString();
        } else {
            echo 'Add Page Портфолио' . PHP_EOL;
        }
        return $this;
    }

    public function setContact(): static
    {
        $render = Render::query()->where('name', 'contact')->where('resource', 'ax_page')->first();

        $model = [
            'title' => 'Контакты',
            'alias' => 'contact',
            'render_id' => $render->id ?? null,
            'user_id' => 6,
        ];
        $page = Page::createOrUpdate($model);
        if ($page->getErrors()) {
            echo $page->getErrorsString();
        } else {
            echo 'Add Page Контакты' . PHP_EOL;
        }
        return $this;
    }

    public function setCatalog(): static
    {
        $category = [
            'title' => 'Разделочные доски',
            'user_id' => 6,
        ];
        $model = [
            'title' => 'Разделочная доска',
            'user_id' => 6,
            'images_copy' => 1,
            'description' => 'Таким образом сложившаяся структура организации представляет собой интересный эксперимент проверки позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же консультация с широким активом влечет за собой процесс внедрения и модернизации позиций, занимаемых участниками в отношении поставленных задач. Задача организации, в особенности же начало повседневной работы по формированию позиции играет важную роль в формировании направлений прогрессивного развития.',
            'image' => public_path('/frontend/assets/img/IMG_4151_jpg.JPG'),
            'galleries' => [
                [
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
                    ],
                ],
            ],

        ];
        $modelC = CatalogCategory::createOrUpdate($category);
        if ($modelC->getErrors()) {
            echo $modelC->getErrorsString();
        } else {
            echo 'Add Page Category Product' . PHP_EOL;
            for ($i = 1; $i < 6; $i++) {
                $model['title'] = 'Разделочная доска №' . $i;
                $model['category_id'] = $modelC->id;
                $model['price'] = 2000.00;
                $modelP = CatalogProduct::createOrUpdate($model);
                if ($modelP->getErrors()) {
                    echo $modelP->getErrorsString();
                }
                echo 'Add Page Product' . PHP_EOL;
            }
        }
        return $this;
    }

    public function setCatalogPropertyType(): static
    {
        $models = [
            [
                'title' => 'Строка [без группировки]',
                'resource' => 'ax_catalog_product_has_value_varchar',
                'sort' => 0,
            ],
            [
                'title' => 'Ссылка [без группировки]',
                'resource' => 'ax_catalog_product_has_value_varchar',
                'sort' => 6,
            ],
            [
                'title' => 'Число [без группировки]',
                'resource' => 'ax_catalog_product_has_value_int',
                'sort' => 1,
            ],
            [
                'title' => 'Дробное число 0.00 [без группировки]',
                'resource' => 'ax_catalog_product_has_value_decimal',
                'sort' => 2,
            ],
            [
                'title' => 'Большой текст [без группировки]',
                'resource' => 'ax_catalog_product_has_value_text',
                'sort' => 3,
            ],
            [
                'title' => 'Файл [без группировки]',
                'resource' => 'ax_catalog_product_has_value_varchar',
                'sort' => 5,
            ],
            [
                'title' => 'Изображение [без группировки]',
                'resource' => 'ax_catalog_product_has_value_varchar',
                'sort' => 4,
            ],
        ];
        $modelsNew = [
            [
                'title' => 'Строка',
                'resource' => 'ax_catalog_property_value_varchar',
                'sort' => 0,
            ],
            [
                'title' => 'Ссылка',
                'resource' => 'ax_catalog_property_value_varchar',
                'sort' => 6,
            ],
            [
                'title' => 'Число',
                'resource' => 'ax_catalog_property_value_int',
                'sort' => 1,
            ],
            [
                'title' => 'Дробное число 0.00',
                'resource' => 'ax_catalog_property_value_decimal',
                'sort' => 2,
            ],
            [
                'title' => 'Большой текст',
                'resource' => 'ax_catalog_property_value_text',
                'sort' => 3,
            ],
            [
                'title' => 'Файл',
                'resource' => 'ax_catalog_property_value_varchar',
                'sort' => 5,
            ],
            [
                'title' => 'Изображение',
                'resource' => 'ax_catalog_property_value_varchar',
                'sort' => 4,
            ],
        ];
        $array = array_merge($models, $modelsNew);
        foreach ($array as $post) {
            if (!$model = CatalogPropertyType::query()->where('title', $post['title'])->first()) {
                $model = new CatalogPropertyType();
            }
            $model->title = $post['title'];
            $model->resource = $post['resource'];
            $model->sort = $post['sort'];
            $model->save();
        }
        return $this;
    }

    public function setWidgetsPropertyType(): static
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
        return $this;
    }

    public function setCatalogPaymentType(): static
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
        return $this;
    }

    public function setCatalogDeliveryType(): static
    {
        $models = [
            [
                'title' => 'Служба доставки СДЭК',
                'is_active' => 1,
                'cost' => 350,
            ],
            [
                'title' => 'Курьером по г.Краснодару',
                'is_active' => 1,
                'cost' => 350,
            ],
            [
                'title' => 'Почта Россия',
                'is_active' => 1,
                'cost' => 350,
            ],
        ];
        foreach ($models as $post) {
            if (!$model = CatalogDeliveryType::query()->where('title', $post['title'])->first()) {
                $model = new CatalogDeliveryType();
            }
            $model->cost = $post['cost'];
            $model->title = $post['title'];
            $model->is_active = $post['is_active'];
            $model->setAlias();
            $model->save();
        }
        return $this;
    }

    public function setUnitsParser(): static
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
        return $this;
    }

    public function setCatalogProperty(): static
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
            $model->catalog_property_unit_id = $units->where('national_symbol', $post['unit'])->first()->id;
            $model->save();
        }
        return $this;
    }

    public function setCatalogStoragePlace(): static
    {
        $models = [
            [
                'title' => 'Главный склад',
                'is_place' => 1,
            ],
            [
                'title' => 'Запасной склад',
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
        echo 'Add Catalog storage place' . PHP_EOL;
        return $this;
    }

    public function setCatalogDocumentSubject(): static
    {
        $events = [
            'sale' => [
                'Продажа',
                'debit',
            ],
            'refund' => [
                'Возврат',
                'credit',
            ],
            'coming' => [
                'Поступление',
                'credit',
            ],
            'invoice' => [
                'Счет',
                'debit',
            ],
            'transfer' => [
                'Перемещение',
                'debit',
            ],
            'write_off' => [
                'Списание',
                'debit',
            ],
            'reservation' => [
                'Резервирование',
                'debit',
            ],
            'remove_reserve' => [
                'Снятие с резерва',
                'credit',
            ],
        ];
        $types = FinTransactionType::all();
        $cnt = 0;
        foreach ($events as $key => $event) {
            if (!$model = CatalogDocumentSubject::query()->where('name', $key)->first()) {
                $model = new CatalogDocumentSubject();
                $model->name = $key;
            }
            $model->title = $event[0];
            $model->fin_transaction_type_id = $types->where('name', $event[1])->first()->id;
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' Document Subject' . PHP_EOL;
        return $this;
    }

    public function setCounterparty(): static
    {
        $co = Counterparty::createOrUpdate([
            'user_id' => 7,
            'is_individual' => 1,
        ]);
        echo 'Add Counterparty' . PHP_EOL;
        return $this;
    }

    public function setCatalogDeliveryStatus(): static
    {
        $events = [
            'in_processing' => [
                'В обработке',
                'in_processing',
            ],
            'is_delivered' => [
                'Доставляется',
                'is_delivered',
            ],
            'delivered' => [
                'Доставлен',
                'delivered',
            ],
        ];
        $cnt = 0;
        foreach ($events as $key => $event) {
            if (!$model = CatalogDeliveryStatus::query()->where('key', $key)->first()) {
                $model = new CatalogDeliveryStatus();
                $model->key = $key;
                $model->title = $event[0];
            }
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' Delivery Status' . PHP_EOL;
        return $this;
    }

    public function setCatalogPaymentStatus(): static
    {
        $events = [
            'paid' => [
                'Оплачен',
                'paid',
            ],
            'not_paid' => [
                'Не оплачен',
                'not_paid',
            ],
            'in_processing' => [
                'В обработке',
                'in_processing',
            ],
        ];
        $cnt = 0;
        foreach ($events as $key => $event) {
            if (!$model = CatalogPaymentStatus::query()->where('key', $key)->first()) {
                $model = new CatalogPaymentStatus();
                $model->key = $key;
                $model->title = $event[0];
            }
            if ($model->save()) {
                $cnt++;
            }
        }
        echo 'Add ' . $cnt . ' Payment Status' . PHP_EOL;
        return $this;
    }

    public function changeCatalogProduct(): static
    {
        $model = CatalogProduct::query()->where('title', '!=', 'Масло-Воск')->update(['is_single' => 1]);
        echo 'Change CatalogProduct' . $model . PHP_EOL;
        return $this;
    }

    public function createPermissionTables(): static
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new \RuntimeException('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \RuntimeException('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if (!Schema::hasTable($tableNames['permissions'])) {
            Schema::create($tableNames['permissions'], static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');       // For MySQL 8.0 use string('name', 125);
                $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
                $table->timestamps();
                $table->unique([
                    'name',
                    'guard_name',
                ]);
            });
        }

        if (!Schema::hasTable($tableNames['roles'])) {
            Schema::create($tableNames['roles'], static function (Blueprint $table) use ($teams, $columnNames) {
                $table->bigIncrements('id');
                if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                    $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                    $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
                }
                $table->string('name');       // For MySQL 8.0 use string('name', 125);
                $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
                $table->timestamps();
                if ($teams || config('permission.testing')) {
                    $table->unique([
                        $columnNames['team_foreign_key'],
                        'name',
                        'guard_name',
                    ]);
                } else {
                    $table->unique([
                        'name',
                        'guard_name',
                    ]);
                }
            });
        }

        if (!Schema::hasTable($tableNames['model_has_permissions'])) {
            Schema::create($tableNames['model_has_permissions'], static function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
                $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
                $table->string('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->index([
                    $columnNames['model_morph_key'],
                    'model_type',
                ], 'model_has_permissions_model_id_model_type_index');
                $table->foreign(PermissionRegistrar::$pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                if ($teams) {
                    $table->unsignedBigInteger($columnNames['team_foreign_key']);
                    $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');
                    $table->primary([
                        $columnNames['team_foreign_key'],
                        PermissionRegistrar::$pivotPermission,
                        $columnNames['model_morph_key'],
                        'model_type',
                    ], 'model_has_permissions_permission_model_type_primary');
                } else {
                    $table->primary([
                        PermissionRegistrar::$pivotPermission,
                        $columnNames['model_morph_key'],
                        'model_type',
                    ], 'model_has_permissions_permission_model_type_primary');
                }
            });
        }

        if (!Schema::hasTable($tableNames['model_has_roles'])) {
            Schema::create($tableNames['model_has_roles'], static function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
                $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);
                $table->string('model_type');
                $table->unsignedBigInteger($columnNames['model_morph_key']);
                $table->index([
                    $columnNames['model_morph_key'],
                    'model_type',
                ], 'model_has_roles_model_id_model_type_index');
                $table->foreign(PermissionRegistrar::$pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');
                if ($teams) {
                    $table->unsignedBigInteger($columnNames['team_foreign_key']);
                    $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');
                    $table->primary([
                        $columnNames['team_foreign_key'],
                        PermissionRegistrar::$pivotRole,
                        $columnNames['model_morph_key'],
                        'model_type',
                    ], 'model_has_roles_role_model_type_primary');
                } else {
                    $table->primary([
                        PermissionRegistrar::$pivotRole,
                        $columnNames['model_morph_key'],
                        'model_type',
                    ], 'model_has_roles_role_model_type_primary');
                }
            });
        }

        if (!Schema::hasTable($tableNames['role_has_permissions'])) {
            Schema::create($tableNames['role_has_permissions'], static function (Blueprint $table) use ($tableNames) {
                $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
                $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);
                $table->foreign(PermissionRegistrar::$pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');
                $table->foreign(PermissionRegistrar::$pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');
                $table->primary([
                    PermissionRegistrar::$pivotPermission,
                    PermissionRegistrar::$pivotRole,
                ], 'role_has_permissions_permission_id_role_id_primary');
            });
        }

        app('cache')->store(config('permission.cache.store') !== 'default' ? config('permission.cache.store') : null)->forget(config('permission.cache.key'));

        return $this;
    }

    public function createJobsTables(): static
    {
        if (!Schema::hasTable('ax_main_jobs')) {
            Schema::create('ax_main_jobs', static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
            });
        }

        return $this;
    }

    public function createFailedJobsTables(): static
    {
        if (!Schema::hasTable('ax_main_jobs_failed')) {
            Schema::create('ax_main_jobs_failed', static function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
        }
        return $this;
    }
}
