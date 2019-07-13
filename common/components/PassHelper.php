<?php

namespace common\components;

use Exception;
use Yii;
use yii\base\Component;

/**
 * Class PassHelper - Хелпер для работы с паролем
 *
 * @package common\components
 */
class PassHelper extends Component
{
    /**
     * Соль для пароля
     *
     * @var $salt
     */
    private $salt;

    /**
     * PassHelper constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        /**
         * Получаем соль по умолчанию
         */
        $this->salt = Yii::$app->params['pass_helper']['hash_salt'];

        /**
         * Выполняем родительский constructor
         */
        parent::__construct($config);
    }

    /**
     * Шифруем пароль
     *
     * @param string $password
     * @return string
     * @throws Exception
     */
    public final function encrypt(string $password): string
    {
        /**
         * Сливаем соль с паролем
         *
         * @var string $saltWithPass
         */
        $saltWithPass = $this->mergeSaltAndPass($password);

        /**
         * Шифрование пароля
         *
         * @var string $encryptedPass
         */
        $encryptedPass = Yii::$app->security->generatePasswordHash($saltWithPass);

        return $encryptedPass;
    }

    /**
     * Валидация пароля
     *
     * @param string $password
     * @param string $hash
     * @return bool
     * @throws Exception
     */
    public final function validate(string $password, string $hash): bool
    {
        /**
         * Сливаем соль с паролем
         *
         * @var string $saltWithPass
         */
        $saltWithPass = $this->mergeSaltAndPass($password);

        /**
         * Валидация пароля
         *
         * @var bool $isValid
         */
        $isValid = Yii::$app->security->validatePassword($saltWithPass, $hash);

        return $isValid;
    }

    /**
     * Сливаем соль с паролем
     *
     * @param string $password
     * @return string
     * @throws Exception
     */
    private final function mergeSaltAndPass(string $password): string
    {
        /**
         * Сливаем соль с паролем
         *
         * @var string $saltWithPass
         */
        $saltWithPass = $this->salt . $password . $this->salt;

        return $saltWithPass;
    }
}
