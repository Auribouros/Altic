**What is Altic ?**

Altic allows pupils to train on timestables and teachers to get their results very easily.

**How to install it ?**

Altic is a Symfony app. If you do not know anything about Symfony, I strongly recommend you take a look at [the following](https://symfony.com/doc/current/index.html#gsc.tab=0).

To use it in production mode, type the following :
```
composer install --no-dev --optimize-autoloader
composer dump-autoload --optimize --no-dev --classmap-authoritative
```

[Here](https://medium.com/@runawaycoin/deploying-symfony-4-application-to-shared-hosting-with-just-ftp-access-e65d2c5e0e3d) you will find a guide to install Altic using FTP.

If you want to install it on Heroku, first start [here](https://devcenter.heroku.com/articles/getting-started-with-symfony#deploying-to-heroku).
You need to install a database though. Heroku provides you with a basic plugin to add a [PostgreSQL database](https://www.heroku.com/postgres). [Here](https://devcenter.heroku.com/articles/heroku-postgresql) lies documentation to help you set it up.
