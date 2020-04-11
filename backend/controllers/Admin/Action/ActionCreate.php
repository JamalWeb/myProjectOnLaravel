<?php

namespace backend\controllers\Admin\Action;

use backend\controllers\Admin\AdminController;
use backend\controllers\Base\BaseAction;
use backend\models\User\UserForm;
use Yii;

/** @property-read AdminController $controller */
final class ActionCreate extends BaseAction
{
    /** @var UserForm */
    public $userForm;

    public function run()
    {
        $this->controller->registerMeta('Создание пользователя', '', '');
        $model = $this->getUserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $resultCreate = $this->controller->service->createUser($model->getDto());
            if ($resultCreate) {
                Yii::$app->session->setFlash('success', "Пользователь <b>{$model->getDto()->firstName}</b> создан");
                return $this->controller->redirect(['user/index']);
            }
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
