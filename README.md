Testing portal
==============

Testing portal provide an interface for checking students knowledge in universities.

Installation
-----------

1) Rename app/config/parameters.yml.dist to app/config/parameters.yml and

Popuplate fields for db connection and email sendind

2) Create directories app/cache and app/logs with chmod 0777

3) Apply migration

    php app/console doctrine:migrations:migrate

4) Populate database with initial data

    php app/console doctrine:fixtures:load

5) Install assets

    php app/console assets:install web

6) Create a super administrator

    php app/console fos:user:create --super-admin username email password

*: Change username/email/password for your own data
