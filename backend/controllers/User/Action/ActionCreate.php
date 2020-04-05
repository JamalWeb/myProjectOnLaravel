<?php


namespace backend\controllers\User\Action;


use backend\controllers\Base\BaseAction;
use backend\controllers\User\UserController;
use backend\models\User\UserForm;
use Yii;

/**
 * @property-read UserController $controller
 */
final class ActionCreate extends BaseAction
{
    /** @var UserForm */
    public $userForm;

    public function run(): string
    {
        $this->controller->registerMeta('Создание пользователя', '', '');
        $model = $this->getUserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->controller->service->createUser($model->getDto());
        }

        return $this->controller->render(
            'create',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * @return UserForm
     */
    public function getUserForm(): UserForm
    {
        return new $this->userForm();
    }
}
