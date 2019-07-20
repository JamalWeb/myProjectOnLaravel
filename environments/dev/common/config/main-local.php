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
                ]
            ],
            'on afterOpen'        => function ($event) {
                $event->sender->createCommand("SET search_path TO 'main';")->execute();
            },
        ],
        'mailer' => [
            'class'            => 'yii\swiftmailer\Mailer',
            'viewPath'         => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];
