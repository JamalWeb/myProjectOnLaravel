<?php

namespace backend\controllers;

use backend\controllers\Action\Site\ActionIndex;
use backend\controllers\Action\Site\ActionLogin;
use backend\Entity\Services\User\UserService;
use backend\models\Site\LoginForm;
use common\traits\RegisterMetaTag;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller
 * @property-read UserService $userService
 */
final class SiteController extends Controller
{
    use RegisterMetaTag;

    private $userService;

    /**
     * SiteController constructor.
     * @param $id
     * @param $module
     * @param UserService $userService
     * @param array $config
     */
    public function __construct($id, $module, UserService $userService, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->userService = $userService;
    }

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
