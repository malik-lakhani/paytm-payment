<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'paytm-wallet' => [
        'env' => env('APP_ENV'),
        'merchant_id' => env('YOUR_MERCHANT_ID'),
        'merchant_key' => env('YOUR_MERCHANT_KEY'),
        'merchant_website' => env('YOUR_WEBSITE'),
        'channel' => env('YOUR_CHANNEL'),
        'industry_type' => env('YOUR_INDUSTRY_TYPE'),
        'user' => env('YOUR_USER_NAME'),
        'mobile_number' => env('YOUR_MOBILE_NUMBER'),
        'email' => env('YOUR_EMAIL'),
        'callback_url' => env('CALLBACK_URL'),
    ],
];
