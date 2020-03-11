<?php

namespace common\components;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\registry\RgUser;
use common\models\user\User;
use common\models\user\UserToken;
use Yii;
use yii\base\Exception;

/**
 * Class EmailSendler
 *
 * @package common\components
 */
class EmailSendler
{
    /**
     * @param User $user
     * @return bool
     * @throws BadRequestHttpException
     * @throws Exception
     */
    final public static function registrationConfirmDefaultUser(User $user): bool
    {
        UserToken::generateAccessToken($user, RgUser::TOKEN_TYPE_EMAIL_CONFIRM);
        $userToken = UserToken::get($user, RgUser::TOKEN_TYPE_EMAIL_CONFIRM);

        return Yii::$app->mailer->compose(
            'confirmEmail-html.php',
            [
                'user'      => $user,
                'userToken' => $userToken
            ]
        )
            ->setFrom('info@mappa.one')
            ->setTo($user->email)
            ->setSubject('Подтверждение регистрации')
            ->send();
    }

    /**
     * @param User $user
     */
    final public static function registrationConfirmBusinessUser(User $user): void
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

    /**
     * @param $user
     * @return bool
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public static function userRecovery($user): bool
    {
        UserToken::generateAccessToken($user, RgUser::TOKEN_TYPE_USER_RECOVERY);
        $userToken = UserToken::get($user, RgUser::TOKEN_TYPE_USER_RECOVERY);

        return Yii::$app->mailer->compose(
            'userRecovery-html.php',
            [
                'user'      => $user,
                'userToken' => $userToken
            ]
        )
            ->setFrom('info@mappa.one')
            ->setTo($user->email)
            ->setSubject('Восстановление аккаунта')
            ->send();
    }
}
