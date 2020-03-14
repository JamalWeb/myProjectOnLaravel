<?php

namespace backend\controllers\Action\Site;

use backend\controllers\SiteController;
use yii\base\Action;

/**
 * @property SiteController $controller
 */
class ActionLogin extends Action
{
    public function run(): string
    {
        return $this->controller->render(
            'login'
        );
    }
}
