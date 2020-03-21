<?php

namespace backend\controllers\Site\Action;

use backend\controllers\Base\BaseAction;
use backend\controllers\Site\SiteController;
use backend\models\Site\LoginForm;
use Yii;

/**
 * @property SiteController $controller
 */
final class ActionLogin extends BaseAction
{
    /** @var LoginForm */
    public $loginForm;

    public function run()
    {
        $request = Yii::$app->request;

        $this->controller->registerMeta("{$this->appName} | Вход", '', '');

        if ($request->isPost) {
            $this->loginForm->load($request->post());
            $valid = $this->loginForm->validate();

            if ($valid) {
                $this->controller->authService->signIn($this->loginForm->getDto());

                return $this->controller->goHome();
            }
        }

        return $this->controller->render(
            'login',
            [
                'model' => $this->loginForm,
            ]
        );
    }

    public function init(): void
    {
        $this->loginForm = $this->getLoginForm();
    }

    /**
     * @return LoginForm
     */
    public function getLoginForm(): LoginForm
    {
        return new $this->loginForm();
    }
}
