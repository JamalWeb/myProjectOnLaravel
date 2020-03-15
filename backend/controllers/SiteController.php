<?php

namespace backend\controllers;

use backend\controllers\Action\Site\ActionIndex;
use backend\controllers\Action\Site\ActionLogin;
use backend\models\Site\LoginForm;
use common\traits\RegisterMetaTag;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends Controller
{
    use RegisterMetaTag;

    /**
     * {@inheritdoc}
     */
    public function behaviors(): ?array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'login' => [
                'class' => ActionLogin::class,
                'loginForm' => LoginForm::class,
            ],
            'index' => [
                'class' => ActionIndex::class,
            ],
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
