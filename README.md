# Hashbon MVC

## Steps

1) Create database
```
sudo -u postgres psql -c 'create database hashbon_mvc_db';
```

2) Create users Linear SQL
```
sudo -u postgres psql hashbon_mvc_db -c 'CREATE TABLE public.users (id bigserial NOT NULL, username varchar(50) NOT NULL, password varchar(50) NOT NULL, balance int NOT NULL default 0);';
```

2.1) Create users Full SQL ( то же самое, что 2., для наглядности )
```
CREATE TABLE public.users (
id bigserial PRIMARY KEY,
username varchar(50) NOT NULL,
password varchar(50) NOT NULL,
balance int NOT NULL default 0
);
```

3) Add host
```
echo '127.0.0.1       hashbon-mvc' >> /etc/hosts
```

4) Nginx
```
sudo nano /etc/nginx/sites-available/hashbon_mvc
```

```
server {
    listen 80;
    root /home/andrey/PhpstormProjects/hashbon/hashbon-mvc/src;
    index index.php;
    server_name hashbon-mvc;

    access_log /var/log/nginx/access.log;
    error_log  /var/log/nginx/access.log;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

5) Restart nginx
```
sudo service nginx restart
```


## Task

Создать приложение по работе с финансовыми транзакциями.

Необходимо создать минимальный каркас приложения:
- Одна точка входа;
- Контроллеры (можно ограничиться одним);
- Сущности (тоже хватит одной);
- Сервис (работа с БД);

Приложение должно соответствовать конструкционному шаблону MVC.

В приложении должны присутствовать такие элементы как:
1) Авторизация (пользователь может быть заранее добавлен в БД)
2) Страница управления средствами аккаунта (содержит информацию о текущем балансе и Поле вывода средств с кнопкой "вывести" )

Необходимо представить, что начисление и раздача денег происходит с Вашей родной банковской карты, так что если где-то будут ошибки, то ошибки будут стоить денег.

Деньги должны быть заранее начислены на счет пользователя, то есть делать компоненты для начисления денег не нужно, только для списания (в пределах баланса пользователя).
В случае списания деньги не зачисляются на другой счет, списываем "вникуда".

Сессия должна быть неблокируемой, использовать session_write_close().

Решение не должно использовать очередей, достаточно использования PHP + Mysql и понимания работ транзакций и блокировок записи в БД.

PHP-фреймворки нельзя использовать. ORM'ы нельзя использовать (если используете, то внутри должен быть native SQL).

Использовать boostrap, jQuery и прочие инструменты для html-страницы – можно, но не обязательно, упор идёт именно на серверную часть.
Клиент может быть сделан даже в виде файла index.php, где через echo выводится форма.
Делать html5-красивости и валидации на js нет необходимости, валидация должна быть на уровне php и базы.

Тестовое задание должно быть выложено на личный аккаунт на github.com (можно использовать другие подобные git-системы).