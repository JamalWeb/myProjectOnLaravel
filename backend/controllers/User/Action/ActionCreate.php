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

    public function run()
    {
        $this->controller->registerMeta('Создание пользователя', '', '');
        $model = $this->getUserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $resultCreate = $this->controller->service->createUser($model->getDto());
            if ($resultCreate) {
                Yii::$app->session->setFlash('success', 'Пользователь создан');
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
