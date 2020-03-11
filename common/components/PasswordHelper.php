<?php

namespace common\components;

use Exception;
use Yii;

/**
 * Class PassHelper
 *
 * @package common\components
 */
class PasswordHelper
{
    /**
     * Соль для пароля Mhk-Vorchami-996 в 16-ричной системе
     */
    private const SALT = '365154163F585B4C514A56521622221F';

    /**
     * Генерируем hash пароля
     *
     * @param string $password
     * @return string
     * @throws Exception
     */
    final public static function encrypt(string $password): string
    {
        $saltWithPass = self::addSaltInPassword($password);

        return Yii::$app->security->generatePasswordHash($saltWithPass);
    }

    /**
     * Добавляем соль в пароль
     *
     * @param string $password
     * @return string
     */
    final public static function addSaltInPassword(string $password): string
    {
        return self::SALT . $password . self::SALT;
    }
}
