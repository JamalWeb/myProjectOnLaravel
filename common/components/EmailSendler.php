<?php

namespace common\components;

use api\modules\v1\models\error\BadRequestHttpException;
use common\models\user\User;
use common\models\user\UserToken;
use Yii;
use yii\base\Exception;
use yii\helpers\Html;

/**
 * Class EmailSendler
 *
 * @package common\components
 */
class EmailSendler
{
    /**
     * @param User $user
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public static final function registrationConfirmDefaultUser(User $user): void
    {
        UserToken::generateAccessToken($user, UserToken::TYPE_EMAIL_ACTIVATE);
        $userToken = UserToken::getAccessToken($user, UserToken::TYPE_EMAIL_ACTIVATE);

        $confirmationLink = Html::a('Подтвердить регистрацию', [
            'user/registration-confirm',
            'access_token' => $userToken->access_token
        ]);

        Yii::$app->mailer->compose()
            ->setFrom('from@domain.com')
            ->setTo($user->email)
            ->setSubject('Тема сообщения')
            ->setTextBody('Текст сообщения')
            ->setHtmlBody($confirmationLink)
            ->send();
    }

    /**
     * @param User $user
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public static final function registrationConfirmBusinessUser(User $user): void
    {
//        UserToken::generateToken($user, UserToken::TYPE_EMAIL_ACTIVATE);
//        $userToken = UserToken::getToken($user, UserToken::TYPE_EMAIL_ACTIVATE);

//        $confirmationLink = Html::a('Подтвердить регистрацию', [
//            'user/registration-confirm',
//            'access_token' => $userToken->token
//        ]);

//        Yii::$app->mailer->compose()
//            ->setFrom('from@domain.com')
//            ->setTo('to@domain.com')
//            ->setSubject('Тема сообщения')
//            ->setTextBody('Текст сообщения')
//            ->setHtmlBody('<b>текст сообщения в формате HTML</b>')
//            ->send();
    }

    public static function confirmChangeEmail(User $user, string $email): void
    {
    }
}
