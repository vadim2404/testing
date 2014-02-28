Testing Portal
=========

Installation
--------------

```sh
mysql -uuser -ppassword -e"CREATE DATABASE portal DEFAULT CHARSET utf8;"
git clone https://github.com/vadim2404/testing
curl -sS https://getcomposer.org/installer | php
./composer.phar up
app/console doctrine:migrations:migrate -n
app/console doctrine:fixtures:load -n
app/console fos:user:create --super-admin login email password
app/console fos:js-routing:dump
app/console assetic:dump --force
app/console cache:clear --env=prod
app/console cache:warmup --env=prod
```
Nginx Development Configuration (Example)
-------------------------------

```nginx
upstream phpfcgi {
    server unix:/var/run/php5-fpm.sock;
}

server {
        listen 80;
         
        server_name portal.iv;
        root /var/www/portal.iv/web;

        include /etc/nginx/mime.types;
        default_type application/octet-stream;

        proxy_buffers 8 32k;
        proxy_buffer_size 64k;


        error_log /var/log/nginx/portal.iv.error.log;
        access_log /var/log/nginx/portal.iv.access.log;

        rewrite ^/app_dev\.php/?(.*)$ /$1 permanent;

        location / {
            index app_dev.php;
            try_files $uri @rewriteapp;
        }

        location @rewriteapp {
            rewrite ^(.*)$ /app_dev.php/$1 last;
        }

        location ~ ^/(app|app_dev|config)\.php(/|$) {
            fastcgi_pass phpfcgi;
            fastcgi_buffers 8 32k;
            fastcgi_buffer_size 64k;
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params;
            fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param  HTTPS off;
        }
}

```