<?php

namespace backend\controllers\Admin\Action;

use backend\controllers\Admin\AdminController;
use backend\controllers\Base\BaseAction;

/**
 * @property-read AdminController $controller
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
