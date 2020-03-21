<?php

namespace backend\controllers\Site\Action;

use backend\controllers\Site\SiteController;
use yii\base\Action;
use yii\web\Response;

/**
 * @property-read SiteController $controller
 */
final class ActionLogOut extends Action
{
    public function run(): Response
    {
        $this->controller->authService->logOut();

        return $this->controller->goHome();
    }
}
