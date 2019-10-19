<?php
return [
    'adminEmail'       => 'admin@example.com',
    'exceptApiMethods' => [
        'user/get-genders',
        'user/registration-default-user',
        'user/registration-business-user',
        'user/login',
        'user/reset-auth-token'
    ],
    'defaultValue'     => [
        'language'   => 'Russian',
        'short_lang' => 'ru-RU',
        'timezone'   => 'Europe/Moscow',
    ]
];
