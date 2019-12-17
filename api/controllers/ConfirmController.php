<?php

namespace api\controllers;

use common\components\registry\TableRegistry;
use common\components\registry\UserRegistry;
use common\models\user\User;
use common\models\user\UserToken;
use Exception;
use Throwable;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ConfirmController extends Controller
{
    /**
     * @param $token
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     * @throws Throwable
     */
    public function actionEmail($token)
    {
        $userToken = UserToken::findOne([
            'access_token' => $token,
            'type'         => UserToken::TYPE_EMAIL_CONFIRM
        ]);

        if (is_null($userToken)) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        try {
            $userToken->user->saveModel([
                'status' => UserRegistry::USER_STATUS_ACTIVE
            ]);
            $userToken->delete();
        } catch (Exception $e) {
            throw new BadRequestHttpException('Что-то пошло не так');
        }
    }
}
