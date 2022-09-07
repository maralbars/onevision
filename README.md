# OneVision

## Тестовое задание для кандидата на вакансию back‐end разработчика, ориентировочное время 8 - 12 часов:

### Необходимо реализовать форму обратной связи на следующем стеке:

- Laravel 9
- PostgeSQL

### ТЗ

1) Регистрация\авторизация: стандартный модуль auth (но пользователи должны быть с двумя ролями: менеджер и клиент)
2) Клиенты регистрируются самостоятельно, а аккаунт менеджера должен быть создан заранее с помощью сидера
3) После логина, клиент видит форму обратной связи, а менеджер список заявок. (Все страницы и функционал доступны только авторизованным пользователям и только в соответствии с их привилегиями)
4) Менеджер может просматривать список заявок и отмечать те, на которые ответил.
5) Список заявок:
*ID, тема, сообщение, имя клиента, почта клиента, ссылка на прикрепленный файл, время создания
- клиент может оставлять заявку, но не чаще раза в сутки.
6) На странице создания заявки: тема и сообщение, файловый инпут кнопка "отправить".
- реализовать валидацию через кастомный Реквест
  - тема (обязательное, строка, ограничение длины 255 символов)
  - текст (обязательное, строка)
- в момент обработки формы и создания заявки отправлять менеджеру email со всеми данными
- отправку почты реализовать асинхронно (используя очереди)
- сделать хотя бы частичное покрытие тестами (по желанию)
На вёрстку внимание обращаться не будет, важно оформление кода, phpdoc, использование фич php7+ и возможностей фреймворка.
Ожидаем от Вас ссылку на репозиторий (желательно, чтобы каждый новый функционал был отдельно закоммичен) и сопроводительное сообщение с инструкцией по резвертыванию проекта.

## Решение

### Требования

Данная инструкция подразумевает, что у вас установлены:

- Docker
- PHP 8.1

### Порядок разворачивания приложения:

```
# Copy .env file
cp .env.example .env

# Build docker containers
composer require laravel/sail --dev

# Add alias for sail if you have not it
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# Run Docker-composer in background
sail up -d

# Install all composer and npm dependencies
sail composer i && npm i

# Compile styles and javascript code
sail npm run prod

# Create required tables
sail php artisan migrate

# Add manager account
sail php artisan db:seed --class=ManagerSeeder

# Launch queue worker
sail php artisan queue:work

```

### Тестовая среда

- [Вебсайт](http://localhost)
- [Проверка почтовых сообщений](http://localhost:8025)

### Примечаения

- Тестов нет, ибо никогда раньше их не писал.
- Начал задание в 15:50 6 сентября 2022.
- Завершил задание в 07:50 7 сентября 2022.