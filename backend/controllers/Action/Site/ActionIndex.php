<?php

namespace backend\controllers\Action\Site;

use backend\controllers\SiteController;
use yii\base\Action;

/**
 * @property SiteController $controller
 */
class ActionIndex extends Action
{
    public function run(): string
    {
        return $this->controller->render(
            'index'
        );
    }
}
