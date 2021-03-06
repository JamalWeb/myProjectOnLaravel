<?php

return [
    'adminEmail'       => 'admin@example.com',
    'exceptApiMethods' => [
        'user/get-gender-list',
        'user/registration-default',
        'user/registration-business',
        'user/login',
        'user/reset-auth-token',
        'user/recovery',
        'city/get-list',
        'interest/get-list',
        'event/get-type-list',
        'event/get-status-list'
    ],
    'defaultValue'     => [
        'language'   => 'Russian',
        'short_lang' => 'ru-RU',
        'timezone'   => 'Europe/Moscow',
    ]
];
