<?php
return [
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'   => 'ru-RU',
    'components' => [
        'user'   => [
            'class' => 'common\components\User',
        ],
        'cache'  => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n'   => [
            'translations' => [
                'api' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],
        'mailer' => [
            'viewPath'         => '@common/mail',
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
    ],
    'modules'    => [
        'user'                  => [
            'class'         => 'common\components\User',
            'identityClass' => 'common\models\user\User',
        ],
    ],
];
