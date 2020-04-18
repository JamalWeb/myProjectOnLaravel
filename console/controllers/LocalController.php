<?php


namespace console\controllers;


use common\components\PasswordHelper;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class LocalController extends Controller
{
    public function actionPassword(string $password)
    {
        $passwordHash = PasswordHelper::encrypt($password);

        $rows = Yii::$app->db->createCommand(
            "UPDATE main.user SET password = '$passwordHash'"
        )->execute();

        $message = <<<TEXT
        Success change password users.
        Password hash: $passwordHash
        Password: $password,
        Of rows affected: $rows
TEXT;

        return $this->stdout($message . PHP_EOL, Console::FG_GREEN);
    }
}
