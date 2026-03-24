<?php

return [
    'base_url' => env('EVOAI_BASE_URL', 'http://localhost:8000'),
    'api_prefix' => env('EVOAI_API_PREFIX', '/api/v1'),
    'timeout' => env('EVOAI_TIMEOUT', 30),
    'connect_timeout' => env('EVOAI_CONNECT_TIMEOUT', 10),

    'retry' => [
        'times' => env('EVOAI_RETRY_TIMES', 3),
        'sleep' => env('EVOAI_RETRY_SLEEP', 100),
        'when' => [429, 500, 502, 503, 504],
    ],

    'credentials' => [
        'email' => env('EVOAI_EMAIL'),
        'password' => env('EVOAI_PASSWORD'),
    ],

    'api_key' => env('EVOAI_API_KEY'),

    'client_id' => env('EVOAI_CLIENT_ID'),

    'token' => [
        'cache_key' => 'evoai_token',
        'cache_store' => env('EVOAI_CACHE_STORE'),
        'ttl' => env('EVOAI_TOKEN_TTL', 3300),
        'auto_refresh' => true,
    ],

    'logging' => [
        'enabled' => env('EVOAI_LOGGING', false),
        'channel' => env('EVOAI_LOG_CHANNEL'),
        'redact' => ['password', 'access_token', 'key_value', 'api_key', 'current_password', 'new_password'],
    ],
];
