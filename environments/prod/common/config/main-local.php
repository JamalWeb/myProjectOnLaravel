<?php

use yii\db\pgsql\Schema;

return [
    'components' => [
        'db'     => [
            'class'               => 'yii\db\Connection',
            'dsn'                 => "pgsql:host=206.54.170.70;port=5432;dbname=db_mappa",
            'username'            => 'wAcGgDFInG',
            'password'            => 'IzhX9wHdVY~@uc*m',
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
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
