# Burban App

## Deployment Instructions
1. Install Composer

Use the instructions to install php composer

[Get Composer](https://getcomposer.org/)

2. Clone Codebase

3. Run Composer Install

This will install all the api's dependencies

`$ cd /Burban`

`$ composer install`

4. Set up environment

`$ cp .env.example .env`

`$ cp .env .env.testing`

Dont run the testsuite unless you have a separate .env.testing file that points to a separate testing database because the tests will erase all data in the database. Better yet, don't run the tests when the app is in production. Only run the test on your local machine.

Edit .env with correct environment variables for database, algolia key and google api key

```
APP_NAME='Burban API'
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://burban.com

DB_DATABASE='burbandbname'
DB_USERNAME='dbuser'
DB_PASSWORD='dbuserpassword'

GOOGLE_API=
ALGOLIA_KEY=

```

Laravel has built-in drivers for mysql, sqlite, and prostgresql databases. The database driver can be easily changed with the `DB_CONECTION` env variable.

* MYSQL
```
DB_CONNECTION=mysql
```

* SQLITE
```
DB_CONNECTION=sqlite
```

* POSTGRESQL
```
DB_CONNECTION=pgsql
```


Generate a new Laravel App key.

`$ php artisan key:generate`

5. Run Migrations

`$ php artisan migrate`

## API Documentation

API documentation here

### Endpoints

#### User Endpoints

`/user/login` - POST - 