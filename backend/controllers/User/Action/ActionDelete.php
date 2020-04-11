<?php

namespace backend\controllers\User\Action;

use backend\controllers\User\UserController;
use Yii;
use yii\base\Action;
use yii\web\Response;

/** @property-read UserController $controller */
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
