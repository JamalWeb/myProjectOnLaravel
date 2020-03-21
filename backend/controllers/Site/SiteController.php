<?php

namespace backend\controllers\Site;

use backend\controllers\Base\BaseController;
use backend\controllers\Site\Action\{ActionIndex, ActionLogin, ActionLogOut};
use backend\Entity\Services\User\AuthService;
use backend\models\Site\LoginForm;
use common\traits\RegisterMetaTag;
use yii\filters\AccessControl;
use yii\web\ErrorAction;

/**
 * Site controller
 * @property-read AuthService $authService
 */
final class SiteController extends BaseController
{
    use RegisterMetaTag;

    public $authService;

    /**
     * SiteController constructor.
     * @param $id
     * @param $module
     * @param AuthService $authService
     * @param array $config
     */
    public function __construct($id, $module, AuthService $authService, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->authService = $authService;
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
                        'actions' => ['login', 'error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'login'  => [
                'class'     => ActionLogin::class,
                'loginForm' => LoginForm::class,
            ],
            'index'  => [
                'class' => ActionIndex::class,
            ],
            'logout' => [
                'class' => ActionLogOut::class,
            ],
            'error'  => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
