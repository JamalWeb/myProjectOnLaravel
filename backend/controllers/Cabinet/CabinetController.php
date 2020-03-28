<?php

namespace backend\controllers\Cabinet;

use backend\controllers\Base\BaseController;
use backend\controllers\Cabinet\Action\ActionIndex;
use backend\controllers\Cabinet\Action\ActionUpdateProfile;
use backend\Entity\Services\User\CabinetService;
use backend\models\Cabinet\ProfileForm;
use common\traits\RegisterMetaTag;
use yii\filters\AccessControl;

/**
 * @property-read CabinetService $cabinetService;
 */
final class CabinetController extends BaseController
{
    use RegisterMetaTag;

    public $cabinetService;

    /**
     * CabinetController constructor.
     * @param $id
     * @param $module
     * @param CabinetService $cabinetService
     * @param array $config
     */
    public function __construct($id, $module, CabinetService $cabinetService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cabinetService = $cabinetService;
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
                        'actions' => ['error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' =>
                            [
                                'index',
                                'update-profile',
                            ],
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
            'index'          => [
                'class'       => ActionIndex::class,
                'profileForm' => ProfileForm::class,
            ],
            'update-profile' => [
                'class'       => ActionUpdateProfile::class,
                'profileForm' => ProfileForm::class,

            ],
        ];
    }
}
