<?php

namespace backend\controllers\Moderator\Action\User;

use backend\controllers\Base\BaseAction;
use backend\controllers\Moderator\ModeratorController;
use yii\web\NotFoundHttpException;

/**
 * @property-read ModeratorController $controller
 */
class ActionUserView extends BaseAction
{
    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function run(int $id): string
    {
        $user = $this->controller->service->findOneUser('id', $id);
        $this->controller->registerMeta($user->profile->first_name, '', '');

        return $this->controller->render(
            'user-view',
            [
                'user' => $user
            ]
        );
    }
}
