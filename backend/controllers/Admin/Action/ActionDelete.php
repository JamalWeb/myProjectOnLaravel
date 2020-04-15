<?php

namespace backend\controllers\Admin\Action;

use backend\controllers\Admin\AdminController;
use Yii;
use yii\base\Action;
use yii\web\Response;

/**
 * @property-read AdminController $controller
 */
final class ActionDelete extends Action
{
    public function run(int $id): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'result' => $this->controller->service->deleteUser($id),
        ];
    }
}
