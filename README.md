Paytm-payment
=====================

### Prerequisites

* [Laravel 5.6](http://laravel.com/)


### Set up guide

* Clone the repository using the following command:

```
git clone http://192.168.1.5:10080/bhumika/paytm-payment.git
```

* Dependancies installation

```
composer install
```

* Set up database configuaration in .env file and Run migration

```
php artisan migrate
```

* Set paytm MERCHANT account detail in .env file for detail info see https://business.paytm.com/

```
YOUR_MERCHANT_ID=abcSta41696263698529
YOUR_MERCHANT_KEY=&vv3q@AY0_ZRXFIe
YOUR_WEBSITE=WEBSTAGING
YOUR_CHANNEL=WEB
YOUR_INDUSTRY_TYPE=Retail
YOUR_USER_NAME=7777777777
YOUR_MOBILE_NUMBER=7777777777
YOUR_EMAIL=bhumika@improwised.com
```

* Add mail configuration detail also in .env file to send mail to user

* Visit `/user-registration` route and make payment.
