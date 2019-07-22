<?php

namespace common\components;

use common\models\user\User;
use common\models\user\UserToken;
use Yii;

class EmailSendler
{
    public static final function registrationConfirm(User $user): void
    {
        $userToken = UserToken::generate($user->id, UserToken::TYPE_EMAIL_ACTIVATE);

        Yii::$app->mailer->compose()
            ->setFrom('from@domain.com')
            ->setTo('to@domain.com')
            ->setSubject('Тема сообщения')
            ->setTextBody($userToken->token)
            ->setHtmlBody('<b>текст сообщения в формате HTML</b>')
            ->send();
    }
}
