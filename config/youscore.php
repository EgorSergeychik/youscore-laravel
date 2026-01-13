<?php

return [
    'base_url' => env('YOUSCORE_BASE_URL', 'https://api.youscore.com.ua'),
    'api_key' => env('YOUSCORE_API_KEY', ''),
    'timeout' => env('YOUSCORE_TIMEOUT', 30),

    'polling' => [
        'enabled' => env('YOUSCORE_POLLING_ENABLED', true),
        'max_attempts' => env('YOUSCORE_POLLING_MAX_ATTEMPTS', 2),
        'delay' => env('YOUSCORE_POLLING_DELAY', 2500),
    ],
];
