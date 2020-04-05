<?php

use yii\db\pgsql\Schema;

return [
    'components' => [
        'db'     => [
            'class'               => 'yii\db\Connection',
            'dsn'                 => "pgsql:host=192.168.83.137;port=5432;dbname=project",
            'username'            => 'vordev',
            'password'            => 'vorDev996',
            'charset'             => 'utf8',
            'enableSchemaCache'   => false,
            'schemaCacheDuration' => 3600,
            'schemaMap'           => [
                'pgsql' => [
                    'class'         => Schema::class,
                    'defaultSchema' => 'main',
                ],
            ],
            'on afterOpen'        => function ($event) {
                $event->sender->createCommand("SET search_path TO 'main';")->execute();
            },
        ],
        'mailer' => [
            'class'            => Mailer::class,
            'viewPath'         => '@common/mail',
            'useFileTransport' => false,
            'transport'        => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => 'jamal.absalimov@yandex.ru',
                'password'   => 'T6jx4jdn!2018',
                'port'       => '587',
                'encryption' => 'TLS',
            ],
        ],
    ],
];
