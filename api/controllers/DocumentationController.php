<?php

namespace api\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller
 */
class DocumentationController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class'      => 'genxoft\swagger\ViewAction',
                'apiJsonUrl' => Url::to(['/documentation/json'], true),
            ],
            'json'  => [
                'class' => 'genxoft\swagger\JsonAction',
                'dirs'  => [
//                    Yii::getAlias('@api/swagger/definitions/'),
                    Yii::getAlias('@api/modules/v1/controllers/BaseController.php'),
                    Yii::getAlias('@api/modules/v1/controllers/UserController.php'),
                ],
            ],
        ];
    }

    public function actionIndex()
    {

    }
}
