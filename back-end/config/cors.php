<?php

return [
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'], // ou ['http://localhost:5173'] se quiser restringir

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];
