<?php

    return [
        'pagination' => [
            'per_page' => 10
        ],
        'delivery' => [
            'tracker_length' => 10
        ],
        'auth' => [
            'token_name' => 'auth_token',
            'default_pass' => env('APP_ADMIN_PASS','admin'),
        ]
    ];