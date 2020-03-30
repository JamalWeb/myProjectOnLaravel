<?php

use common\components\User;
use yii\caching\FileCache;
use yii\i18n\DbMessageSource;
use yii\rbac\DbManager;

return [
    'aliases'    => [
        '@bower'        => '@vendor/bower-asset',
        '@npm'          => '@vendor/npm-asset',
        '@interestPath' => 'upload/system/interest',
        '@setEventImg'  => '@frontend/web/upload/events',
        '@getEventImg'  => 'upload/events',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'language'   => 'ru-RU',
    'components' => [
        'user'        => [
            'class' => User::class,
        ],
        'cache'       => [
            'class' => FileCache::class,
        ],
        'i18n'        => [
            'translations' => [
                'api' => [
                    'class' => DbMessageSource::class,
                ],
            ],
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
    ],
    'modules'    => [
        'user' => [
            'class'         => User::class,
            'identityClass' => \common\models\user\User::class,
        ],
    ],
];
