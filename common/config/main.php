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
        'user' => [
            'class'           => 'amnah\yii2\user\Module',
            'loginEmail'      => true,
            'requireEmail'    => true,
            'requireUsername' => false,
            'loginUsername'   => false,
            'modelClasses'    => [
                'User'         => 'common\models\user\User',
                'Profile'      => 'common\models\user\Profile',
                'Role'         => 'common\models\user\Role',
                'Organization' => 'common\models\user\Organization',
                'LoginForm'    => 'common\models\LoginForm',
            ],
            'emailViewPath'   => '@common/mail',
        ],
    ],
];
