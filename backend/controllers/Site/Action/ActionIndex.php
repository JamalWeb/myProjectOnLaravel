<?php

namespace backend\controllers\Site\Action;

use backend\controllers\Base\BaseAction;
use backend\controllers\Site\SiteController;

/**
 * @property SiteController $controller
 */
final class ActionIndex extends BaseAction
{
    public function run(): string
    {
        $this->controller->registerMeta("{$this->appName} | Список пользователей", '', '');

        return $this->controller->render(
            'index',
            [
                'appName' => $this->appName,
            ]
        );
    }
}
