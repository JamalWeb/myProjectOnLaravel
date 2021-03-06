<?php

use backend\config\Bootstrap\UserBootstrap;
use yii\console\controllers\FixtureController;
use yii\console\controllers\MigrateController;
use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'id'                  => 'app-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', UserBootstrap::class],
    'controllerNamespace' => 'console\controllers',
    'aliases'             => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'controllerMap' => [
        'fixture' => [
            'class'     => FixtureController::class,
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class'         => MigrateController::class,
            'migrationPath' => [
                '@console/migrations',
                '@yii/rbac/migrations',
                '@yii/i18n/migrations',
            ],
        ],
    ],
    'components'    => [
        'log' => [
            'targets' => [
                [
                    'class'  => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params'        => $params,
];
