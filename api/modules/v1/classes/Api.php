<?php

namespace api\modules\v1\classes;

use Yii;
use common\models\user\User;

/**
 * Class Api
 *
 * @package api\modules\v1\classes
 */
class Api
{
    /**
     * @var User
     */
    public $user = null;

    /**
     * Api constructor.
     */
    public function __construct()
    {
        /**
         * Получаем текущего пользователя
         */
        $this->user = $this->getUser();
    }

    final private function getUser()
    {
        /**
         * Идентификтор аутентифицированного пользователя
         *
         * @var int $userId
         */
        $userId = Yii::$app->user->getId();

        /**
         * Текущий пользователь
         *
         * @var User $user
         */
        $user = User::findIdentity($userId);

        return $user;
    }
}
