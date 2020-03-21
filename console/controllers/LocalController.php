<?php


namespace console\controllers;


use common\components\PasswordHelper;
use Yii;
use yii\console\Controller;

class LocalController extends Controller
{
    public function actionPassword()
    {
        $password = PasswordHelper::encrypt('123456');

        Yii::$app->db->createCommand(
            <<<SQL
        UPDATE main.user SET password = '$password'
SQL
        )->execute();
    }

}