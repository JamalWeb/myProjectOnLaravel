<?php


namespace backend\controllers\Cabinet;


use backend\controllers\Base\BaseController;
use backend\controllers\Cabinet\Action\ActionIndex;
use common\traits\RegisterMetaTag;
use yii\filters\AccessControl;

final class CabinetController extends BaseController
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
                'class' => ActionIndex::class,
            ],
        ];
    }

}