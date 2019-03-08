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

-- `/user/login`

Login a user
Returns a valid API Token for the user

"POST"

Body
* `email`
    required,
    valid email,
    max characters: 255
* `password`
    required,
    string,
    min characters: 8
    max characters: 255

-----------------------------------------

-- `/user/register`

Create a new user

"POST"

Body
* `email`
    required,
    valid email,
    unique email,
    max characters: 255
* `password`
    required,
    string,
    min characters: 8
    max characters: 255
* `password_confirmation`
    required,
    string,
    min characters: 8
    max characters: 255
    must match password field

-----------------------------------------

-- `/user/updatePassword`

Update a user's password

"PATCH"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

Body
* `current_password`
    The user's current password,
    required,
    string,
    max characters: 255

* `password`
    The user's newly chosen password,
    required,
    string,
    min characters: 8
    max characters: 255

* `password_confirmation`
    required,
    string,
    min characters: 8
    max characters: 255
    must match password field

-----------------------------------------

-- `/user/updateEmail`

Update a user's email

"PATCH"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

Body
* `current_password`
    required,
    string,
    min characters: 8
    max characters: 255
* `new_email`
    required,
    string,
    valid email,
    max characters: 255

-----------------------------------------

-- `/user/logout`

Logout a user

"GET"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

-----------------------------------------

-- `/user/delete`

Delete a user

"DELETE"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

Body
* `password`
    required,
    string,
    max characters: 255

-----------------------------------------

-- `/user/verify-email?api_token={usersAPItoken}`

This route exists to verify a user has a valid email address.
When a new user registers, a link would be send to their email address containing their api token.

"GET"

Query String Parameter:
`api_token={usersAPItoken}`

-----------------------------------------

#### Business Endpoints

-- `/businesses`

Create a new business

"POST"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

Body
* `name`
    required,
    string,
    unique,
    max characters: 255
* `street_address`
    required,
    string,
    max characters: 255
* `city`
    required,
    string,
    max characters: 255
* `state`
    required,
    string,
    max characters: 2
* `phone`
    required,
    string,
    max characters: 255
* `summary`
    required,
    string,
    max characters: 500

-----------------------------------------

-- `/businesses/{businessId}`

Returns a single business

"GET"

-----------------------------------------

-- `/businesses/{businessId}`

A Business User can update their business

"PATCH"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

Body
* `name`
    string,
    unique,
    max characters: 255
* `street_address`
    string,
    max characters: 255
* `city`
    string,
    max characters: 255
* `state`
    string,
    max characters: 2
* `phone`
    string,
    max characters: 255
* `summary`
    string,
    max characters: 500

-----------------------------------------

-- `/businesses/{businessId}`

A Business User can delete their business

"DELETE"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

-----------------------------------------

-- `/businesses/{businessId}/deals`

Return all deals that belong to a business

"GET"

#### Business Endpoints