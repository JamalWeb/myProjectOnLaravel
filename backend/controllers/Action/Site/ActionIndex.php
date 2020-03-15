<?php

namespace backend\controllers\Action\Site;

use backend\controllers\Base\BaseAction;
use backend\controllers\SiteController;
use Yii;

/**
 * @property SiteController $controller
 */
class ActionIndex extends BaseAction
{
    public function run(): string
    {
        $this->controller->registerMeta("{$this->appName} | Главная", '', '');

        $user = Yii::$app->user->identity;

        return $this->controller->render(
            'index',
            [
                'appName' => $this->appName,
                'user' => $user,
            ]
        );
    }
}
