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
    'days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday','sunday'],
    'FOOD_TYPE' => ['veg'=>'Veg','nonveg'=>'Non-veg','both'=>'Both'],
    'DEFAULT_CITY' => 1,
    'USER_TYPE' => ['admin'=>'admin','customer'=> 'customer'],
    'ADDRESS_TYPE' => ['Home'=>'Home','Office'=>'Office'],
    'DEFAULT_HALF_VEG_TIFFIN' => ['veg_sabaji','chapati','others'],
    'DEFAULT_HALF_NONVEG_TIFFIN' => ['non_veg_sabaji','chapati','others'],
    'LUNCH_ORDER_MAX_TIME' => '11:30 am',
    'DINNER_ORDER_MAX_TIME' => '06:30 pm',
    'ORDER_TYPE_LUNCH' => 2,
    'ORDER_TYPE_DINNER' => 3,
    'DISH_TYPE_OTHER' => 6,
];
