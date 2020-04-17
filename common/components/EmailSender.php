<?php

namespace common\components;

use api\modules\v1\models\error\BadRequestHttpException;
use backend\Entity\Services\User\Dto\UserCreateDto;
use common\components\registry\RgUser;
use common\models\event\Event;
use common\models\user\User;
use common\models\user\UserToken;
use Yii;
use yii\base\Exception;

/**
 * Class EmailSender
 *
 * @package common\components
 */
class EmailSender
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
                'userToken' => $userToken,
            ]
        )
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($user->email)
            ->setSubject('Подтверждение регистрации')
            ->send();
    }

    /**
     * @param UserCreateDto $dto
     * @return bool
     */
    final public static function registrationConfirmSystemUser(UserCreateDto $dto): bool
    {
        return Yii::$app->mailer->compose(
            'confirmEmailSysUser-html.php',
            [
                'dto' => $dto,
            ]
        )
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($dto->email)
            ->setSubject('Подтверждение регистрации')
            ->send();
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function changeStatusBusinessProfile(User $user): bool
    {
        return Yii::$app->mailer->compose(
            'changeStatusBProfile-html.php',
            [
                'user' => $user
            ]
        )
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($user->email)
            ->setSubject('Ваш статус бизнес профиля')
            ->send();
    }

    /**
     * @param Event $event
     * @return bool
     */
    public static function changeStatusEvent(Event $event): bool
    {
        return Yii::$app->mailer->compose(
            'changeStatusEvent-html.php',
            [
                'event' => $event
            ]
        )
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($event->user->email)
            ->setSubject('Статус созданного события')
            ->send();
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
                'userToken' => $userToken,
            ]
        )
            ->setFrom('info@mappa.one')
            ->setTo($user->email)
            ->setSubject('Восстановление аккаунта')
            ->send();
    }
}
