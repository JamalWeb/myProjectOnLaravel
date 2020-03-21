<?php


namespace backend\controllers\Cabinet;


use backend\controllers\Base\BaseController;
use backend\controllers\Cabinet\Action\ActionIndex;
use backend\Entity\Services\User\ProfileService;
use backend\models\Cabinet\ProfileForm;
use common\traits\RegisterMetaTag;
use yii\filters\AccessControl;

/**
 * @property-read ProfileService $profileService;
 */
final class CabinetController extends BaseController
{
    use RegisterMetaTag;

    public $profileService;

    public function __construct($id, $module, ProfileService $profileService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->profileService = $profileService;
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
                        'actions' => ['index'],
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
            'index' => [
                'class'       => ActionIndex::class,
                'profileForm' => ProfileForm::class,
            ],
        ];
    }

}