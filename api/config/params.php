<?php
return [
    'adminEmail'       => 'admin@example.com',
    'exceptApiMethods' => [
        'user-gender/get',
        'user/registration-default-user',
        'user/registration-business-user',
        'user/login',
        'user/reset-auth-token',
        'user/recovery',
        'city/get',
        'interest/get',
        'event/get-type-list',
        'event/create',
    ],
    'defaultValue'     => [
        'language'   => 'Russian',
        'short_lang' => 'ru-RU',
        'timezone'   => 'Europe/Moscow',
    ]
];
