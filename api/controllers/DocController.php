<?php

namespace api\controllers;

use genxoft\swagger\JsonAction;
use genxoft\swagger\ViewAction;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller
 */
class DocController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class'      => ViewAction::class,
                'apiJsonUrl' => Url::to(['/doc/json'], true),
            ],
            'json'  => [
                'class' => JsonAction::class,
                'dirs'  => [
//                    Yii::getAlias('@api/swagger/definitions/'),
                    Yii::getAlias('@api/modules/v1/controllers'),
                ],
            ],
        ];
    }
}
