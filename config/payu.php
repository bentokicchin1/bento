<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the environment of the payment gateway.
    | Possible options:
    | "test" For testing and development.
    | "secure" For live payment.
    |
    */

    'env' => 'secure',

    /*
    |--------------------------------------------------------------------------
    | Default Account to use
    |--------------------------------------------------------------------------
    |
    | The account to be used for Payment
    |
    */
<<<<<<< HEAD
    'default' => 'payubiz',
=======
    'default' => 'payumoney',
>>>>>>> 13fca010cb47823b92e59a13047d9c05ca65e56e

    /*
    |--------------------------------------------------------------------------
    | All Accounts array
    |--------------------------------------------------------------------------
    |
    | All the different accounts with its names
    |
    */
    'accounts' => [
        /*
        |--------------------------------------------------------------------------
        | Account Credentials
        |--------------------------------------------------------------------------
        |
        | The account name and credentials which are found in the PayuBiz or
        | PayuMoney Console.
        |
        | key   => (string)     Merchant Key.
        | salt  => (string)     Merchant Salt.
        | money => (boolean)    Is it a payumoney account?
        | auth  => (string)     Authorization Token if it is a payumoney account.
        |
        */
        'payubiz' => [
            'key' => config('constants.PAYU_MERCHANT_KEY'),
            'salt' => config('constants.PAYU_MERCHANT_SALT'),
            'money' => false,
            'auth' => config('constants.PAYU_MERCHANT_AUTH_HEADER')
        ],

        'payumoney' => [
            'key' => config('constants.PAYU_MERCHANT_KEY'),
            'salt' => config('constants.PAYU_MERCHANT_SALT'),
<<<<<<< HEAD
            'money' => false,
=======
            'money' => true,
>>>>>>> 13fca010cb47823b92e59a13047d9c05ca65e56e
            'auth' => config('constants.PAYU_MERCHANT_AUTH_HEADER')
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payu Endpoint.
    |--------------------------------------------------------------------------
    |
    | Payment endpoint for Payu.
    |
    */
    'endpoint' => config('constants.PAYU_MERCHANT_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Payment Store Driver
    |--------------------------------------------------------------------------
    |
    | This is the config for storing the payment info. I recommend to use
    | database driver for storing then use it for your own use.
    | Options : "database", "session".
    | Note: If you use session driver make sure you are using secure = true
    | in config/session.php
    |
    */
    'driver' => 'session',

    /*
    |--------------------------------------------------------------------------
    | Payu Payment Table
    |--------------------------------------------------------------------------
    |
    | This is table that will be used for storing the payment information.
    | Run: php artisan vendor:publish to get the table in the migrations
    | directory. If you did change the table name then specify here.
    |
    */
    'table' => 'payu_payments',
];
