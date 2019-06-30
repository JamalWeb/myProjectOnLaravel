<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            //The document preview addesss:http://api.yourhost.com/site/doc
            'doc' => [
                'class' => 'light\swagger\SwaggerAction',
                'restUrl' => \yii\helpers\Url::to(['/site/api'], true),
            ],
            //The resultUrl action.
            'api' => [
                'class' => 'light\swagger\SwaggerApiAction',
                //The scan directories, you should use real path there.
                'scanDir' => [
                    Yii::getAlias('@api/modules/versions/v1/swagger'),
                    Yii::getAlias('@api/modules/versions/v1/controllers'),
                    Yii::getAlias('@api/modules/versions/v1/models'),
                    Yii::getAlias('@api/models'),
                ],
                //The security key
                'api_key' => 'test',
                'cache' => 'cache',
                'cacheKey' => 'api-swagger-cache', // default is 'api-swagger-cache'
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
        return Yii::getAlias('@api/modules/versions/v1/controllers');
    }
}
