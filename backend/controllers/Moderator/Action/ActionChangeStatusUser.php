<?php


namespace backend\controllers\Moderator\Action;


use backend\controllers\Base\BaseAction;
use backend\controllers\Moderator\ModeratorController;
use Yii;
use yii\web\Response;

/**
 * @property-read ModeratorController $controller
 */
class ActionChangeStatusUser extends BaseAction
{
    public function run(int $id): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'result' => $this->controller->service->changeStatus($id)
        ];
    }
}