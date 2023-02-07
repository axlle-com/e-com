<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

1. Язык программирования: `PHP 8.0`
2. Реляционная база данных `MySQL 8` при желании легко переехать на `PostgreSQL 15` [`Navicat premium import`] 
3. Framework: `Laravel 9`
```
Запуск приложения:
```
1. Клонируем в текущую директорию `git clone git@bitbucket.org:axlle-com/a-shop.git .`
2. Создаем базу данных `DATABASE:ax_linoor`; `USERNAME:root`; `PASSWORD:`
3. Файл `.env.example` переименовываем в `.env` и заполняем подключение к БД
4. Запускаем команду `composer update`
5. При проблеме composer `COMPOSER_MEMORY_LIMIT=-1 composer update`
6. Запускаем команду `php artisan migrate` или лучше `php artisan first:dump` если нужны тестовые данные
7. Если возникли проблемы с базой `storage/db/db.sql` можно взять дамп
8. `storage/db/shop.mwb` Лежит схема MySQL Workbench, можно развернуть
9. После миграций все базы будут развернуты, тестовый пользователь `login:axlle@mail.ru | password:558088` url `/admin/login`

---
На память
1. `php artisan cache:clear`
2. `php artisan route:clear`
3. `php artisan config:clear`
4. `php artisan view:clear`
---

