<?php


namespace backend\controllers\Confirm\Action;


use backend\controllers\Confirm\ConfirmController;
use backend\controllers\Confirm\models\VerifyEmailForm;
use Yii;
use yii\base\Action;
use yii\web\Response;

/**
 * @property-read ConfirmController $controller
 */
class ActionEmail extends Action
{
    /** @var VerifyEmailForm */
    public $form;

    public function run(string $token): Response
    {
        new $this->form($token);
        $this->controller->service->verifyEmail($token);
        Yii::$app->session->setFlash('success', 'Почта подтверждена');

        return $this->controller->goHome();
    }


}
