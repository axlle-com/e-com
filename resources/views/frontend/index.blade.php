<?php

/**
 * @var $title string
 */

$title = $title ?? 'Новый сотрудник';
$classMethods = App\Common\Http\Route::all();
?>
@extends('frontend.layout',['title' => $title])
@section('content')
{{--    <div class="container">--}}
{{--        <div>1. Язык программирования: `PHP 8.0` </div>--}}
{{--        <div>2. Реляционная база данных `MySQL 5.7` при желании легко переехать на `PostgreSQL 14`</div>--}}
{{--        <div>3. Framework: `Laravel 9` </div>--}}
{{--        <div>```</div>--}}
{{--            Запуск приложения:--}}
{{--        <div>```</div>--}}
{{--        <div>Тестовый сайт `https://test.axlle.ru`</div>--}}
{{--        <div>1. Клонируем в текущую директорию `git clone https://axlle-com@bitbucket.org/axlle-com/simple-wallet.git .` </div>--}}
{{--        <div>2. Создаем базу данных `DATABASE:v_temp`; `USERNAME:root`; `PASSWORD:`</div>--}}
{{--        <div>3. Файл `.env.example` переименовываем в `.env` и заполняем подключение к БД</div>--}}
{{--        <div>4. Запускаем команду `composer update`</div>--}}
{{--        <div>5. При проблеме composer `COMPOSER_MEMORY_LIMIT=-1 composer `</div>--}}
{{--        <div>6. Запускаем команду `php artisan migrate`</div>--}}
{{--        <div>7. Если возникли проблемы с базой `storage/db/db.sql` можно взять дамп</div>--}}
{{--        <div>8. После миграций все базы будут развернуты, тестовый пользователь `login:axlle@mail.ru | password:558088`</div>--}}
{{--        <div>9. Запускаем команду для парсинга валют `php artisan cur --p=number` number : период - количество последних дней, по умолчанию 1 день</div>--}}
{{--        <div>10. Запускаем команду `php artisan test:wallet` заполняем тестовыми данными</div>--}}
{{--        <?php foreach ($classMethods as $method) { ?>--}}
{{--            <div>--}}
{{--                <?php if ($method !== 'all') { ?>--}}
{{--                    <div><?php $item = App\Common\Http\Route::{$method}(); ?></div>--}}
{{--                    <div><?= '---' ?></div>--}}
{{--                    <div></div>--}}
{{--                    <div><?= $item['title'] ?></div>--}}
{{--                    <div></div>--}}
{{--                    <div> `method: <?= $item['method'] ?> ` </div>--}}
{{--                    <div></div>--}}
{{--                    <div>```</div>--}}
{{--                    <div><?= '/api/app/v' . $item['version'] . '/' . $item['route'] ?></div>--}}
{{--                    <div>```</div>--}}
{{--                    <div></div>--}}
{{--                    <div><?= $item['comments'] ?></div>--}}
{{--                    <div>```</div>--}}
{{--                    <div>Правила валидации: </div>--}}
{{--                    <div>```</div>--}}
{{--                    <div>```</div>--}}
{{--                        <?php foreach ($item['rule'] as $key => $rule) { ?>--}}
{{--                            <div> &#32; "<?= $key ?>":"<?= $rule ?>"</div>--}}
{{--                        <?php } ?>--}}
{{--                    <div>```</div>--}}
{{--                <?php } ?>--}}
{{--            </div>--}}
{{--        <?php } ?>--}}
{{--    </div>--}}
@endsection
