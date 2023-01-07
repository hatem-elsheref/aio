<?php

return [
    'default'     => env('DB_CONNECTION', 'mysql'),

    'mysql' => [
        'DB_HOST'     => env('DB_HOST', '127.0.0.1'),
        'DB_USER'     => env('DB_USER', 'root'),
        'DB_PASS'     => env('DB_PASS', ''),
        'DB_NAME'     => env('DB_NAME', 'aio'),
        'DB_PORT'     => env('DB_PORT', 3306),
    ]

];