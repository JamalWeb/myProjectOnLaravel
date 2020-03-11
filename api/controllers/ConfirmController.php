<?php

namespace api\controllers;

use common\components\registry\RgUser;
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
    public function actionEmail($token): void
    {
        $userToken = UserToken::findOne(
            [
                'access_token' => $token,
                'type' => RgUser::TOKEN_TYPE_EMAIL_CONFIRM
            ]
        );

        if ($userToken === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        try {
            $userToken->user->saveModel(
                [
                    'status' => RgUser::STATUS_ACTIVE
                ]
            );
            $userToken->delete();
        } catch (Exception $e) {
            throw new BadRequestHttpException('Что-то пошло не так');
        }
    }
}
