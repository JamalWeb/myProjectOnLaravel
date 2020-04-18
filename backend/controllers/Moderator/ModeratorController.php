<?php

namespace backend\controllers\Moderator;

use backend\controllers\Base\BaseController;
use backend\controllers\Moderator\Action\Event\{ActionChangeStatusEvent,
    ActionEventList,
    ActionUserListFilter,
    ActionViewEvent
};
use backend\controllers\Moderator\Action\User\{ActionChangeStatusUser, ActionUserList, ActionUserView};
use backend\Entity\Moderator\Service\ModeratorService;
use backend\models\Event\EventSearch;
use backend\models\User\UserSearch;
use common\helpers\UserPermissionsHelper;
use common\traits\RegisterMetaTag;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * @property-read ModeratorService $service
 */
class ModeratorController extends BaseController
{
    use RegisterMetaTag;

    public $service;

    /**
     * ModeratorController constructor.
     * @param $id
     * @param $module
     * @param ModeratorService $service
     * @param array $config
     */
    public function __construct($id, $module, ModeratorService $service, $config = [])
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
                            'user-list',
                            'user-view',
                            'change-status-user',
                            'event-list',
                            'event-view',
                            'change-status-event',
                            'user-list-filter'
                        ],
                        'allow'   => true,
                        'roles'   => [
                            UserPermissionsHelper::ROLE_ADMIN,
                            UserPermissionsHelper::ROLE_MODERATOR,
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'user-list'           => [
                'class'        => ActionUserList::class,
                'userSearch'   => UserSearch::class,
                'dataProvider' => ActiveDataProvider::class
            ],
            'user-view'           => [
                'class' => ActionUserView::class
            ],
            'change-status-user'  => [
                'class' => ActionChangeStatusUser::class
            ],
            'event-list'          => [
                'class'        => ActionEventList::class,
                'eventSearch'  => EventSearch::class,
                'dataProvider' => ActiveDataProvider::class
            ],
            'event-view'          => [
                'class' => ActionViewEvent::class
            ],
            'change-status-event' => [
                'class' => ActionChangeStatusEvent::class
            ],
            'user-list-filter'    => [
                'class' => ActionUserListFilter::class
            ]
        ];
    }
}
