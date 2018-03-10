<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application CONSTANS
    |--------------------------------------------------------------------------
    |
    | Store all conatstnts here.
    |
    */
    'email' =>  env('DEFAULT_EMAIL', ''),
    'number' =>  env('DEFAULT_MOBILE_NUMBER', ''),
    'address' =>  env('DEFAULT_LOCATION', ''),
    'BULK_SMS_USERNAME' => env('BULK_SMS_USERNAME'),
    'BULK_SMS_PASSWORD' => env('BULK_SMS_PASSWORD'),
    'BULK_SMS_SENDER' => env('BULK_SMS_SENDER'),
    'BULK_SMS_URL' => env('BULK_SMS_URL'),
    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
    'DEFAULT_CITY' => 1,
];
