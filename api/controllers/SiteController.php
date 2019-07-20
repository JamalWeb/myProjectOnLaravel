<?php

namespace api\controllers;

use api\swagger\MySwaggerAction;
use api\swagger\WebApiSwaggerAction;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions()
    {
        $scanDir = [
            Yii::getAlias('@api/swagger/definitions/'),
            Yii::getAlias('@api/modules/v1/controllers/BaseController.php'),
            Yii::getAlias('@api/modules/v1/controllers/UserController.php'),
        ];

        return [
            'doc' => [
                'class'   => MySwaggerAction::class,
                'restUrl' => Url::to(['/site/api'], true),
            ],
            'api' => [
                'class'    => WebApiSwaggerAction::class,
                'scanDir'  => $scanDir,
                'cache'    => 'cache',
                'cacheKey' => 'api-swagger-cache',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return Yii::getAlias('@api/modules/v1/controllers');
    }
}
