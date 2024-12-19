
## Инструкция

Проект работает на основе docker, 

Сборка:

```
docker compose build
```

Запуск:

```
docker compose up -d
```

Если падает ошибка ```Class "Modules\Users\Http\Controllers\Api\UserController" does not exist```, то нужно запустить команду 

```bash
composer dump-autoload
```

Весь код работы с пользователями лежит в папке 'modules'

Для проверки запросов через postman в корне лежит коллекция запросов ```securitm.ru.postman_collection.json```

Для запуска миграций и заполнения БД выполняем обычные команды:

```bash
php artisan migrate
php artisan db:seed  
```

Проверки на авторизацию нет, поэтому роуты api без проверок
