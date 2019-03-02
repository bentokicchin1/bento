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

    'PAYU_SANDBOX_BASE_URL' => env('PAYU_SANDBOX_BASE_URL'),
    'PAYU_MERCHANT_BASE_URL' => env('PAYU_MERCHANT_BASE_URL'),

    'PAYU_MERCHANT_KEY' => env('PAYU_MERCHANT_KEY'),
    'PAYU_MERCHANT_SALT' => env('PAYU_MERCHANT_SALT'),
    'PAYU_MERCHANT_AUTH_HEADER' => env('PAYU_MERCHANT_AUTH_HEADER'),

    'PAYU_SENDING_HASH_SEQUENCE' => 'key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10',

    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday','sunday'],
    'FOOD_TYPE' => ['veg'=>'Veg','nonveg'=>'Non-veg','both'=>'Both'],
    'DEFAULT_CITY' => 1,
    'USER_TYPE' => ['admin'=>'admin','customer'=> 'customer'],
    'ADDRESS_TYPE' => ['Home'=>'Home','Office'=>'Office'],
    'DEFAULT_HALF_VEG_TIFFIN' => ['veg_sabaji','chapati'],
    'DEFAULT_HALF_NONVEG_TIFFIN' => ['non_veg_sabaji','chapati'],
    'LUNCH_ORDER_MAX_TIME' => '11:30 am',
    'DINNER_ORDER_MAX_TIME' => '18:30 pm',
    'DASHBOARD_ORDER_MAX_TIME' => '03:00 pm',
    'ORDER_TYPE_LUNCH' => 2,
    'ORDER_TYPE_DINNER' => 3,
    'DISH_TYPE_OTHER' => 6,
];
