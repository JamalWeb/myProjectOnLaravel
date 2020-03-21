<?php

namespace backend\controllers\Action\Site;

use backend\controllers\Base\BaseAction;
use backend\controllers\SiteController;

/**
 * @property SiteController $controller
 */
final class ActionIndex extends BaseAction
{
    public function run(): string
    {
        $this->controller->registerMeta("{$this->appName} | Главная", '', '');

        return $this->controller->render(
            'index',
            [
                'appName' => $this->appName,
            ]
        );
    }
}
