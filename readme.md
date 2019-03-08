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

Deletes a user

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

A business user Creates a new business

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

Anyone Returns a single business

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


#### Deals Endpoints

-- `/businesses/{businessId}/deals`

Anyone Return all deals that belong to a business

"GET"

-----------------------------------------

-- `/deals`

Anyone return all deals

"GET"

-----------------------------------------

-- `/deals/{dealId}`

Anyone Return a single deal

"GET"

-----------------------------------------

-- `/deals`

A business user Creates a new deal

"POST"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

Body
* `title`
    required,
    string,
    max characters: 255
* `description`
    required,
    string,
    max characters: 255
* `start_date`
    required,
    valid date (format: YYYY-MM-DD),
    after or equal to today,
    before or equal to `end_date`
* `end_date`
    required,
    valid date (format: YYYY-MM-DD),
    after or equal to `end_date`

-----------------------------------------

-- `/deals/{dealId}`

A business user Updates an existing deal

"PATCH"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

Body
* `title`
    string,
    max characters: 255
* `description`
    string,
    max characters: 255
* `start_date`
    valid date (format: YYYY-MM-DD),
    before or equal to `end_date`
* `end_date`
    valid date (format: YYYY-MM-DD),
    after or equal to `end_date`

-----------------------------------------

-- `/deals/{dealId}`

A business user Deletes a deal

"DELETE"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

-----------------------------------------

-- `/deals/saved`

A user gets their saved deals

"GET"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

-----------------------------------------

-- `/deals/saved`

A user saves a deal

"POST"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

-----------------------------------------

-- `/deals/saved/{dealId}`

A user deletes a saved deal
This removes the deal from the user's saved deals list

"DELETE"

Headers:
`['HTTP_Authorization': 'Bearer {usersAPItoken}']`

### Email verification

There are events set up to send an email when a new user registers in order to verify they have used a valid email address. Until email is set up with a third part service such as mailgun or sparkpost, this
email will not get sent.

Email address for a user can be manually validated by making a GET request to this endpoint

`/user/verify-email?api_token={usersAPItoken}`

Where {usersAPItoken} is the user's api token.

This probably shouldn't be used in production. Email addresses should be verified.

### Business Users

A User cannot create a business unless they are a business user. There is currently no endpoint that will make a user a business user. 

Going into the database, finding that user, and setting the `business_user` column to `true` will make them a business user, and they will then be able to create their business.

### Geocoding

When a business is created, the address used will be geocoded via Google's Geocoding API, and latitude and longitude coordinates will be returned and saved in the database.

These coordinates can be used to determine nearby businesses to the user.

[Google Geocoding API docs](https://developers.google.com/maps/documentation/geocoding/intro)

### Algolia

Anytime a record is created or updated, it is indexed in Algolia. Algolia provides fast searching of records. This would be useful if search was implemented. Algolia also supports geolocation via the coordinates of a business.

[Algolia Geolocation Docs](https://www.algolia.com/doc/guides/managing-results/refine-results/geolocation/)