<?php

namespace backend\Entity\Services\User;

use backend\Entity\Services\User\Dto\UserLoginDto;
use Yii;

class AuthService
{
    public function signIn(UserLoginDto $userLoginDto): bool
    {
        return Yii::$app->user->login($userLoginDto->user, $userLoginDto->rememberMe ? 3600 * 24 * 30 : 0);
    }

    public function logOut(): bool
    {
        return Yii::$app->user->logout();
    }
}
