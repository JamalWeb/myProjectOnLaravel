<?php
return [
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'user'       => [
            'class' => 'common\components\User',
        ],
        'cache'      => [
            'class' => 'yii\caching\FileCache',
        ],
        'passHelper' => [
            'class' => 'common\components\PassHelper',
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
