<?php

namespace backend\controllers\Admin;

use backend\controllers\Admin\Action\ActionCreate;
use backend\controllers\Admin\Action\ActionDelete;
use backend\controllers\Admin\Action\ActionIndex;
use backend\controllers\Admin\Action\ActionView;
use backend\controllers\Base\BaseController;
use backend\Entity\Services\User\UserService;
use backend\models\User\UserForm;
use backend\models\User\UserSearch;
use common\helpers\UserPermissionsHelper;
use common\traits\RegisterMetaTag;
use yii\filters\AccessControl;
use yii\web\ErrorAction;

/**
 * @property-read UserService $service
 */
final class AdminController extends BaseController
{
    use RegisterMetaTag;

    public $service;

    /**
     * SiteController constructor.
     * @param $id
     * @param $module
     * @param UserService $service
     * @param array $config
     */
    public function __construct($id, $module, UserService $service, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
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
                        'actions' => [
                            'index',
                            'view',
                            'delete',
                            'create',
                        ],
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
            'index'  => [
                'class'       => ActionIndex::class,
                'modelSearch' => UserSearch::class,
            ],
            'view'   => [
                'class' => ActionView::class,
            ],
            'delete' => [
                'class' => ActionDelete::class,
            ],
            'create' => [
                'class'    => ActionCreate::class,
                'userForm' => UserForm::class,
            ],
            'error'  => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
