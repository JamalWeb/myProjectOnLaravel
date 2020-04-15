<?php

namespace backend\controllers\Moderator\Action;

use backend\controllers\Base\BaseAction;
use backend\controllers\Moderator\ModeratorController;
use common\components\ArrayHelper;
use Yii;
use yii\web\Response;

/**
 * @property-read ModeratorController $controller
 */
class ActionChangeStatusUser extends BaseAction
{
    public function run(int $id): array
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $key = $request->post('editableIndex') !== null ? "{$request->post('editableIndex')}.status_id" : 'status_id';

        $newStatusId = ArrayHelper::getValue(
            $request->post('User'),
            $key
        );

        return [
            'result' => $this->controller->service->changeStatus($id, $newStatusId)
        ];
    }
}
