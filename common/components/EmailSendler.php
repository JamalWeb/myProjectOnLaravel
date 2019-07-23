<?php

namespace common\components;

use common\models\user\User;
use common\models\user\UserToken;
use Yii;
use yii\helpers\Html;

class EmailSendler
{
    public static final function registrationConfirm(User $user): void
    {
        $userToken = UserToken::generate($user->id, UserToken::TYPE_EMAIL_ACTIVATE);

        $confirmationLink = Html::a('Подтвердить регистрацию', [
            'user/registration-confirm',
            'access_token' => $userToken->token
        ]);

       Yii::$app->mailer->compose([
            'html' => 'layouts/html'
        ], [
            'content' => $confirmationLink
        ])
            ->setCharset('UTF-8')
            ->setFrom('from@domain.com')
            ->setTo($user->email)
            ->setSubject('Подтверждение регистрации')
            ->send();
    }
}
