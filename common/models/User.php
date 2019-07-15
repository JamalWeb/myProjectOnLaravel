<?php

namespace common\models;

use common\models\system\BaseModel;
use Yii;
use common\components\PassHelper;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use Exception;
use yii\helpers\ArrayHelper;

/**
 * Модель таблицы "user".
 *
 * @property int    $id           Идентификатор пользователя
 * @property int    $user_type_id Идентификатор типа пользователя
 * @property string $email        Почтовый адрес
 * @property string $password     Пароль
 * @property string $token        Уникальный ключ идентификации
 * @property bool   $is_banned    Бан (1 - вкл. 0 - выкл.) | default = 0
 * @property string $banned_at    Дата бана
 * @property string $login_in_ip  Авторизация с IP
 * @property string $login_in_at  Дата входа
 * @property string $logout_in_at Дата выхода
 * @property string $created_at   Дата создания
 * @property string $updated_at   Дата последнего обновления
 */
class User extends BaseModel
{
    /**
     * Константы статуса бана пользователя
     */
    const BAN_ACTIVE = 1;
    const BAN_INACTIVE = 0;

    /**
     * Хелпер для работы с паролем
     *
     * @var PassHelper $passHelper
     */
    private $passHelper;

    /**
     * User constructor.
     *
     * @param array $config
     * @throws InvalidConfigException
     */
    public function __construct($config = [])
    {
        $this->passHelper = Yii::$app->get('passHelper');

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_type_id', 'email', 'password', 'token'], 'required'],
            [['user_type_id'], 'default', 'value' => null],
            [['user_type_id'], 'integer'],
            [['is_banned'], 'boolean'],
            [['banned_at', 'login_in_at', 'logout_in_at', 'created_at', 'updated_at'], 'safe'],
            [['email', 'password', 'token', 'login_in_ip'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'user_type_id' => 'User Type ID',
            'email'        => 'Email',
            'password'     => 'Password',
            'token'        => 'Token',
            'is_banned'    => 'Is Banned',
            'banned_at'    => 'Banned At',
            'login_in_ip'  => 'Login In Ip',
            'login_in_at'  => 'Login In At',
            'logout_in_at' => 'Logout In At',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Проверка пароля
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     * @throws Exception
     */
    public function validatePassword($password)
    {
        $isValid = $this->passHelper->validate($password, $this->password);

        return $isValid;
    }

    /**
     * Сменить пароль
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password = $this->passHelper->encrypt($password);
    }

    public static final function findByEmail(string $email): User
    {
        /**
         * Пользователь
         *
         * @var User $user
         */
        $user = self::findOne([
            'email'     => $email,
            'is_banned' => self::BAN_INACTIVE
        ]);

        return $user;
    }

    /**
     * Создание нового пользователя
     *
     * @param array $data
     * @return User
     * @throws InvalidConfigException
     * @throws Exception
     */
    public static final function create(array $data): self
    {
        $data = ArrayHelper::merge($data, [
            'token' => Yii::$app->security->generateRandomString()
        ]);

        $newUser = new self($data);

        if (!$newUser->validate() || !$newUser->save()) {
            Yii::debug($newUser->getFirstErrors(), 'user');
            throw new InvalidArgumentException('Ошибка при создании пользователя');
        }

        return $newUser;
    }
}
