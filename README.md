<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

1. Язык программирования: `PHP 8.0`
2. Реляционная база данных `MySQL 5.7` при желании легко переехать на `PostgreSQL 14`
3. Framework: `Laravel 9`
```
Запуск приложения:
```
1. Клонируем в текущую директорию `git clone git@bitbucket.org:axlle-com/a-shop.git .`
2. Создаем базу данных `DATABASE:a_shop`; `USERNAME:root`; `PASSWORD:`
3. Файл `.env.example` переименовываем в `.env` и заполняем подключение к БД
4. Запускаем команду `composer update`
5. При проблеме composer `COMPOSER_MEMORY_LIMIT=-1 composer update`
6. Запускаем команду `php artisan migrate`
7. Если возникли проблемы с базой `storage/db/db.sql` можно взять дамп
8. После миграций все базы будут развернуты, тестовый пользователь `login:axlle@mail.ru | password:558088`
9. Запускаем команду для парсинга валют `php artisan cur --p=number` number : период - количество последних дней, по умолчанию 1 день
10. Запускаем команду `php artisan test:data` заполняем тестовыми данными
---
На память
1. `php artisan cache:clear`
2. `php artisan route:clear`
3. `php artisan config:clear`
4. `php artisan view:clear`
---

###Методы для AJAX


###Методы для работы с кошельком
Метод для авторизации
`method: post `
```
/api/app/v1/login
```
Метод выдает токен для `Bearer authentication`
```
Правила валидации:
```
```
"email":"required|email"
"password":"required"
```
---
Метод для регистрации
`method: post `
```
/api/app/v1/registration
```
```
Правила валидации:
```
```
"first_name":"required|string"
"last_name":"required|string"
"email":"required|email"
"password":"required|min:6|confirmed"
"password_confirmation":"required|min:6"
```
---
Метод для создания кошелька
`method: post `
```
/api/app/v1/set-wallet
```
Метод закрыт Guard-ом, доступ по `Bearer authentication`
```
Правила валидации:
```
```
"currency":"required|string|in:RUB,USD"
"deposit":"required|numeric"
```
---
Получить данные кошелька
`method: post `
```
/api/app/v1/get-wallet
```
Метод закрыт Guard-ом, доступ по `Bearer authentication`
```
Правила валидации:
```
```
```
---
Получить список транзакций
`method: post `
```
/api/app/v1/get-transaction
```
Метод закрыт Guard-ом, доступ по `Bearer authentication`
```
Правила валидации:
```
```
"transaction_id":"nullable|integer"
"transaction_value":"nullable|numeric"
"wallet_id":"nullable|integer"
"currency_id":"nullable|integer"
"currency_name":"nullable|string|in:RUB,USD"
"currency_title":"nullable|string"
"reason_id":"nullable|integer"
"reason_name":"nullable|string|in:refund,stock,transfer"
"reason_title":"nullable|string"
"type_id":"nullable|integer"
"type_name":"nullable|string|in:credit,debit"
"type_title":"nullable|string"
```
---
Создать транзакцию
`method: post `
```
/api/app/v1/set-transaction
```
Метод закрыт Guard-ом, доступ по `Bearer authentication`
```
Правила валидации:
```
```
"value":"required|numeric"
"currency":"required|string|in:RUB,USD"
"reason":"required|string|in:refund,stock,transfer"
"type":"required|string|in:credit,debit"
```
