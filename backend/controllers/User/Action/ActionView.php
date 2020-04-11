<?php

namespace backend\controllers\User\Action;

use backend\controllers\Base\BaseAction;
use backend\controllers\User\UserController;

/**
 * @property-read UserController $controller
 */
final class ActionView extends BaseAction
{
    public function run(int $id): string
    {
        $user = $this->controller->service->findOne('id', $id);

        $this->controller->registerMeta("Пользователь: {$user->username}", '', '');

        return $this->controller->render(
            'view',
            [
                'user' => $user,
            ]
        );
    }
}
