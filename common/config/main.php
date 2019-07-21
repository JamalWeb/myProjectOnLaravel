<?php
return [
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'   => 'ru-RU',
    'components' => [
        'user'  => [
            'class' => 'common\components\User',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n'  => [
            'translations' => [
                'api' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
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
                'Profile'      => 'common\models\Profile',
                'Role'         => 'common\models\Role',
                'Organization' => 'common\models\Organization',
                'LoginForm'    => 'common\models\LoginForm',
            ],
            'emailViewPath'   => '@common/mail',
        ],
    ],
];
