<?php

namespace api\modules\v1\classes;

use Yii;
use common\models\user\User;
use yii\web\BadRequestHttpException;

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

    /**
     * Проверка параметров
     *
     * @param       $request
     * @param array $params
     * @param bool  $checkForAvailabilityOnly
     * @throws BadRequestHttpException
     */
    public function validateRequest(array $request, array $params, bool $checkForAvailabilityOnly = false)
    {
        foreach ($params as $param) {
            if ($checkForAvailabilityOnly && !isset($request[$param])) {
                throw new BadRequestHttpException("empty_param|{$param}");
            } else {
                if (!isset($request[$param]) || empty($request[$param])) {
                    throw new BadRequestHttpException("empty_param|{$param}");
                }
            }
        }
    }
}
