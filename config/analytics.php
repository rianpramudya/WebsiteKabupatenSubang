<?php

return [

    'property_id' => env('ANALYTICS_PROPERTY_ID'),

    'service_account_credentials_json' => storage_path('app/service-account-credentials.json'),

    'cache_lifetime_in_minutes' => 60 * 24,

    'cache' => [
        'store' => 'file',
    ],
];
