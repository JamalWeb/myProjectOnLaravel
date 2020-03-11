<?php

use api\modules\v1\ApiModule;
use api\modules\v1\handler\ErrorHandler;
use common\models\user\User;
use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-api',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap'           => ['log'],
    'modules'             => [
        'v1' => [
            'class' => ApiModule::class,
        ],
    ],
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-api',
        ],
        'user'         => [
            'identityClass'   => User::class,
            'enableSession'   => false,
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'response'     => [
            'format'  => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'errorHandler' => [
            'class' => ErrorHandler::class,
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
            ],
        ],
        'urlManagerFront'    => [
            'class'           => 'yii\web\urlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
            ],
        ],
    ],
    'params'              => $params,
];
