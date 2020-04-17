<?php


namespace backend\controllers\Moderator\Action\Event;


use backend\controllers\Base\BaseAction;
use backend\controllers\Moderator\ModeratorController;
use yii\web\Response;

/**
 * @property-read ModeratorController $controller
 */
class ActionUserListFilter extends BaseAction
{
    public function run(string $q): Response
    {
        $results = $this->controller->service->userFilter($q);

        return $this->controller->asJson(
            [
                'results' => $results
            ]
        );
    }

}