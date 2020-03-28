<?php

namespace backend\controllers\Cabinet\Action;

use backend\controllers\Base\BaseAction;
use backend\controllers\Cabinet\CabinetController;
use backend\models\Cabinet\ProfileForm;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * @property-read CabinetController $controller
 */
final class ActionUpdateProfile extends BaseAction
{
    /** @var ProfileForm */
    public $profileForm;

    public function run(): ?array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $model = $this->getProfileForm();

        if ($request->isPost && $model->load($request->post())) {
            $resultValidate = ActiveForm::validate($model);

            if (empty($resultValidate)) {
                return [
                    'result' => $this->controller->cabinetService->save($model->getDto()),
                ];
            }

            return $resultValidate;
        }

        return [];
    }

    /**
     * @return ProfileForm
     */
    public function getProfileForm(): ProfileForm
    {
        return new $this->profileForm(Yii::$app->user);
    }
}
