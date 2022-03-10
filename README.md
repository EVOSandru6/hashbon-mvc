# Hashbon MVC

## Steps

1) Create database
```
sudo -u postgres psql -c 'create database hashbon_mvc_db';
```

2) Create users Linear SQL
```
sudo -u postgres psql hashbon_mvc_db -c 'CREATE TABLE public.users (id bigserial NOT NULL, username varchar(50) NOT NULL UNIQUE, password varchar(50) NOT NULL, balance int NOT NULL default 0);';
```

2.1) Create users Full SQL ( то же самое, что 2., для наглядности )
```
CREATE TABLE public.users (
id bigserial PRIMARY KEY,
username varchar(50) NOT NULL UNIQUE,
password varchar(50) NOT NULL,
balance int NOT NULL default 0
);
```

3) Change Hosts
```
sudo nano /etc/hosts
```
Add line:
```
127.0.0.1       hashbon-mvc
```

4) Nginx (Указать свои пути до проекта и до php8.1-fpm.sock)
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

6) Создать пользователя можно командой:
```
make init
```
