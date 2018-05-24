Paytm-payment
=====================

### Prerequisites

* [Laravel 5.6](http://laravel.com/)


### Set up guide

* Clone project

```
git clone http://192.168.1.5:10080/bhumika/paytm-payment.git
```

* Change Directory

```
cd paytm-payment
```

* Install all dependencies

```
composer install
```

* Create a .env file

```
Create a .env file in root of the project as per `.env.example` supplied, make changes according to your detail and for more detail of merchant account please see https://business.paytm.com/.
```

* Generate application key

```
php artisan key:generate
```

* Link the storage

```
php artisan storage:link
```

* Create database in mysql

```
create database `databaseName`
```

* Database migration

```
php artisan migrate

```

* Add mail configuration detail also in .env file to send ticket in mail to user

* To generate ticket open `/` or `/user-registration` route and make payment using paytm.

* For admin user, open `manage/users` route.

* All ticket pdf are generated in `ticket_pdf` folder in storage/public directory.
