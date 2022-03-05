<?php

return [
    'server' => [
        'protocol' => env('INVOKE_SERVER_PROTOCOL', 'http'),
        'host' => env('INVOKE_SERVER_HOST', 'host'),
        'port' => env('INVOKE_SERVER_PORT', 8000),
        'pathPrefix' => env('INVOKE_SERVER_PATH', '/api/invoke'),
    ],
    'inputMode' => [
        'convertStrings' => true,
    ],
    'types' => [
        'alwaysRequireName' => false,
        'alwaysReturnName' => false,
    ],
];