<?php

namespace backend\controllers\Action\Site;

use backend\controllers\Base\BaseAction;
use backend\controllers\SiteController;
use backend\models\Site\LoginForm;
use Yii;

/**
 * @property SiteController $controller
 */
class ActionLogin extends BaseAction
{
    /** @var LoginForm */
    public $loginForm;

    public function run(): string
    {
        $this->controller->registerMeta("{$this->appName} | Вход", '', '');

        $model = $this->getLoginForm();
        $request = Yii::$app->request;

        if ($request->isPost && $model->load($request->post())) {
            Yii::$app->session->setFlash('success', 'Данные были загружены');
        }

        return $this->controller->render(
            'login',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * @param array $params
     * @return LoginForm
     */
    public function getLoginForm(array $params = []): LoginForm
    {
        /** @var LoginForm $model */
        $model = new $this->loginForm();

        if (!empty($params)) {
            $model->load($params);
        }
        return $model;
    }
}
