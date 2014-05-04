Testing Portal
=========

Installation
--------------

```sh
mysql -uuser -ppassword -e"CREATE DATABASE portal DEFAULT CHARSET utf8;"
git clone https://github.com/vadim2404/testing
cd testing
curl -sS https://getcomposer.org/installer | php
./composer.phar up
app/console doctrine:migrations:migrate -n
app/console doctrine:fixtures:load -n
app/console fos:user:create --super-admin login email password
app/console fos:js-routing:dump
app/console assetic:dump --force
app/console cache:clear --env=prod
app/console cache:warmup --env=prod
echo "*/1 * * * * `pwd`/app/console swiftmailer:spool:send --env=prod" | crontab
nohup app/console bstu:test-org:verify >/dev/null 2>&1 &
sudo setfacl -Rn -m u:"www-data":rwX -m u:`whoami`:rwX app/cache app/logs
sudo setfacl -dRn -m u:"www-data":rwX -m u:`whoami`:rwX app/cache app/logs
```
Nginx 
-----

### Dev-env

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

### Prod-env

Generate ssl certificate

```ssh
openssl req -x509 -newkey rsa:2048 -keyout key.pem -out cert.pem -days 999
```
Permanent redirect from http to https

```nginx
server {
    listen 80;     
    server_name portal.iv;
    rewrite ^(.*) https://$host$1 permanent;
}
```
Nginx-ssl config

```nginx
upstream phpfcgi-ssl {
    server unix:/var/run/php5-fpm.sock;
}

server {
        listen 443 ssl;
        keepalive_timeout 70;
         
        server_name portal.iv;
        root /var/www/portal.iv/web;

        include /etc/nginx/mime.types;
        default_type application/octet-stream;

        proxy_buffers 8 32k;
        proxy_buffer_size 64k;

        ssl_protocols       SSLv3 TLSv1 TLSv1.1 TLSv1.2;
        ssl_ciphers         AES128-SHA:AES256-SHA:RC4-SHA:DES-CBC3-SHA:RC4-MD5;
        ssl_certificate     /etc/nginx/keys/cert.pem;
        ssl_certificate_key /etc/nginx/keys/key.pem;
        ssl_session_cache   shared:SSL:10m;
        ssl_session_timeout 10m;
                  
        error_log /var/log/nginx/portal.iv.error.log;
        access_log /var/log/nginx/portal.iv.access.log;
                           
        rewrite ^/app\.php/?(.*)$ /$1 permanent;
                                    
        location / {
            index app.php;
            try_files $uri @rewriteapp;
        }
                                                                 
        location @rewriteapp {
            rewrite ^(.*)$ /app.php/$1 last;
        }
                                                                                      
        location ~ ^/app\.php(/|$) {
            fastcgi_pass phpfcgi-ssl;
            fastcgi_buffers 8 32k;
            fastcgi_buffer_size 64k;
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params;
            fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param  HTTPS on;
        }
}
```
