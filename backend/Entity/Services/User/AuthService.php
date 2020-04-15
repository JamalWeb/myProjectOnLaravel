<?php

namespace backend\Entity\Services\User;

use backend\Entity\Services\User\Dto\UserLoginDto;
use common\components\registry\RgUser;
use common\models\user\UserToken;
use Throwable;
use Yii;
use yii\db\StaleObjectException;

class AuthService
{
    /**
     * @param UserLoginDto $userLoginDto
     * @return bool
     */
    public function signIn(UserLoginDto $userLoginDto): bool
    {
        return Yii::$app->user->login($userLoginDto->user, $userLoginDto->rememberMe ? 3600 * 24 * 30 : 0);
    }

    /**
     * @return bool
     */
    public function logOut(): bool
    {
        return Yii::$app->user->logout();
    }

    /**
     * @param string $token
     * @return bool
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function verifyEmail(string $token): bool
    {
        $userToken = UserToken::findOne(['access_token' => $token]);

        if ($userToken !== null) {
            $user = $userToken->user;
            $user->status_id = RgUser::STATUS_ACTIVE;
            $user->save();
            $userToken->delete();
            $dto = new UserLoginDto();
            $dto->user = $user;

            return $this->signIn($dto);
        }

        return false;
    }
}
