<?php


namespace backend\controllers\Moderator\Action\Event;

use backend\controllers\Moderator\ModeratorController;
use common\components\ArrayHelper;
use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @property-read ModeratorController $controller
 */
class ActionChangeStatusEvent extends Action
{
    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function run(int $id): array
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $key = $request->post('editableIndex') !== null ? "{$request->post('editableIndex')}.status_id" : 'status_id';

        $newStatusId = ArrayHelper::getValue(
            $request->post('Event'),
            $key
        );

        return [
            'result' => $this->controller->service->changeStatusEvent($id, $newStatusId)
        ];
    }
}