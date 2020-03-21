<?php


namespace backend\controllers\Action\Site;


use Yii;
use yii\base\Action;
use yii\web\Response;

class ActionLogOut extends Action
{
    public function run(): Response
    {
        Yii::$app->user->logout();

        return $this->controller->goHome();
    }

}