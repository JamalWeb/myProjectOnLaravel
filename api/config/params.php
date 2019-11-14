<?php
return [
    'adminEmail'       => 'admin@example.com',
    'exceptApiMethods' => [
        'user-gender/get',
        'user/registration-default-user',
        'user/registration-business-user',
        'user/login',
        'user/reset-auth-token',
        'city/get',
        'user/recovery',
        'interest/get',
    ],
    'defaultValue'     => [
        'language'   => 'Russian',
        'short_lang' => 'ru-RU',
        'timezone'   => 'Europe/Moscow',
    ]
];
