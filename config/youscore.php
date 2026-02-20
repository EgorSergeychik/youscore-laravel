<?php

return [
    'base_url' => env('YOUSCORE_BASE_URL', 'https://api.youscore.com.ua'),
    'timeout' => env('YOUSCORE_TIMEOUT', 30),

    'api_keys' => [
        'data' => env('YOUSCORE_DATA_API_KEY', ''),
        'analytics' => env('YOUSCORE_ANALYTICS_API_KEY', ''),
    ],

    'polling' => [
        'enabled' => env('YOUSCORE_POLLING_ENABLED', true),
        'max_attempts' => env('YOUSCORE_POLLING_MAX_ATTEMPTS', 2),
        'delay' => env('YOUSCORE_POLLING_DELAY', 2500),
    ],
];
