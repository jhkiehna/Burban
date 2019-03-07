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

Edit .env with correct environment variables.

You'll need to update the `APP_NAME`, `APP_ENV`, `APP_DEBUG`, `APP_URL`, AND `FRONTEND_URL` variables accordingly.

```
APP_NAME='Burban API'
APP_ENV=production
APP_DEBUG=false
APP_URL='http://api.example.com'
FRONTEND_URL='https://example.com'
```

You'll also need to update the DB variables to match the database on the server.

Laravel has built-in drivers for `mysql`, `sqlite`, and `pgsql` databases. The database driver can be easily changed with the `DB_CONECTION` env variable.

```
DB_CONNECTION=mysql
DB_DATABASE='burbandbname'
DB_USERNAME='dbuser'
DB_PASSWORD='dbuserpassword'
```

Algolia and Google API keys need to be set

```
SCOUT_DRIVER='algolia'
SCOUT_QUEUE=true
ALGOLIA_APP_ID='algoliaAppId'
ALGOLIA_SECRET='algoliaAPIkey'

GOOGLE_API_KEY='googleAPIkey'

```

If you plan to send emails from the API, then these values will need to be set as well

Laravel has built in drivers for `mailgun`, `mandrill`, `sparkpost`, and `ses` as well.

```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_USERNAME='mail provider username'
MAIL_PASSWORD='mail provider password'

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