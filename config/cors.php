<?php
return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Разрешить все HTTP-методы (GET, POST, PUT, DELETE и т.д.)

    'allowed_origins' => ['*'], // Разрешить доступ с любых доменов

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Разрешить все заголовки

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
