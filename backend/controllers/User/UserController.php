<?php


namespace backend\controllers\User;


use backend\controllers\Base\BaseController;
use backend\controllers\User\Action\ActionIndex;
use backend\Entity\Services\User\AuthService;
use backend\models\User\UserSearch;
use common\helpers\UserPermissionsHelper;
use common\traits\RegisterMetaTag;
use yii\filters\AccessControl;
use yii\web\ErrorAction;

final class UserController extends BaseController
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
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => [
                            UserPermissionsHelper::ROLE_ADMIN,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'index' => [
                'class'       => ActionIndex::class,
                'modelSearch' => UserSearch::class,
            ],
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
