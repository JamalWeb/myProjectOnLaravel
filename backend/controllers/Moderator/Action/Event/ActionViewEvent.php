<?php


namespace backend\controllers\Moderator\Action\Event;


use backend\controllers\Base\BaseAction;
use backend\controllers\Moderator\ModeratorController;

/**
 * @property-read ModeratorController $controller
 */
class ActionViewEvent extends BaseAction
{
    public function run(int $id): string
    {
        $event = $this->controller->service->findOneEvent('id', $id);

        $this->controller->registerMeta($event->name, '', '');

        return $this->controller->render(
            'event-view',
            [
                'model' => $event
            ]
        );
    }
}