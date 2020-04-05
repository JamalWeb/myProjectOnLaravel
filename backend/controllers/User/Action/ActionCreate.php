<?php


namespace backend\controllers\User\Action;


use backend\controllers\Base\BaseAction;
use backend\controllers\User\UserController;
use backend\models\User\UserForm;

/**
 * @property-read UserController $controller
 */
final class ActionCreate extends BaseAction
{
    /** @var UserForm */
    public $userForm;

    public function run(): string
    {
        return $this->controller->render('create');
    }

    /**
     * @return UserForm
     */
    public function getUserForm(): UserForm
    {
        return new $this->userForm();
    }

}
