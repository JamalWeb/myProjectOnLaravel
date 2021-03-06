<?php

use backend\config\Bootstrap\UserBootstrap;
use backend\controllers\{Admin\AdminController,
    Cabinet\CabinetController,
    Confirm\ConfirmController,
    Moderator\ModeratorController,
    Site\SiteController
};
use common\models\user\User;
use kartik\grid\Module;
use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-backend',
    'basePath'            => dirname(__DIR__),
    'name'                => 'Mappa',
    'controllerNamespace' => 'backend\controllers',
    'controllerMap'       => [
        'site'      => SiteController::class,
        'cabinet'   => CabinetController::class,
        'admin'     => AdminController::class,
        'confirm'   => ConfirmController::class,
        'moderator' => ModeratorController::class
    ],
    'bootstrap'           => ['log', UserBootstrap::class],
    'modules'             => [
        'gridview' => ['class' => Module::class]
    ],
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-backend',
        ],
        'user'         => [
            'identityClass'   => User::class,
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
            ],
        ],
    ],
    'params'              => $params,
];
