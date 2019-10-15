<?php

namespace common\models\user;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\DateHelper;
use common\components\PasswordHelper;
use common\models\base\BaseModel;
use Exception;
use Yii;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int         $id             Идентификатор пользователя
 * @property int         $type_id        Идентификатор типа
 * @property int         $role_id        Идентификатор роли
 * @property string      $email          Электронная почта
 * @property string      $username       Никнейм
 * @property string      $password       Пароль
 * @property string      $auth_key       Ключ необходимый для авторизации
 * @property bool        $status         Статус активности (1 - вкл. 0 - выкл.) | default = 1
 * @property string      $logged_in_ip   IP адрес авторизации
 * @property string      $logged_in_at   Дата авторизации
 * @property string      $logout_in_ip   IP адрес выхода
 * @property string      $logout_in_at   Дата выхода
 * @property string      $created_ip     IP адрес с которого создали
 * @property bool        $is_banned      Бан (1 - вкл. 0 - выкл.) | default = 0
 * @property string      $banned_reason  Причина бана
 * @property string      $banned_at      Дата бана
 * @property string      $created_at     Дата создания
 * @property string      $authKey
 * @property string      $updated_at     Дата обновления
 * @property ActiveQuery $profile        Профиль
 * @property ActiveQuery $role           Роль
 */
class User extends BaseModel implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_UNCONFIRMED_EMAIL = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'role_id', 'email', 'password'], 'required'],
            [['type_id', 'role_id', 'status'], 'default', 'value' => null],
            [['type_id', 'role_id', 'status'], 'integer'],
            [['logged_in_at', 'logout_in_at', 'banned_at', 'created_at', 'updated_at'], 'safe'],
            [['is_banned'], 'boolean'],
            [['email', 'username', 'password', 'auth_key', 'logged_in_ip', 'logout_in_ip', 'created_ip', 'banned_reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'type_id'       => Yii::t('app', 'Type ID'),
            'role_id'       => Yii::t('app', 'Role ID'),
            'email'         => Yii::t('app', 'Email'),
            'username'      => Yii::t('app', 'Username'),
            'password'      => Yii::t('app', 'Password'),
            'auth_key'      => Yii::t('app', 'Auth Key'),
            'status'        => Yii::t('app', 'Status'),
            'logged_in_ip'  => Yii::t('app', 'Logged In Ip'),
            'logged_in_at'  => Yii::t('app', 'Logged In At'),
            'logout_in_ip'  => Yii::t('app', 'Logout In Ip'),
            'logout_in_at'  => Yii::t('app', 'Logout In At'),
            'created_ip'    => Yii::t('app', 'Created Ip'),
            'is_banned'     => Yii::t('app', 'Is Banned'),
            'banned_reason' => Yii::t('app', 'Banned Reason'),
            'banned_at'     => Yii::t('app', 'Banned At'),
            'created_at'    => Yii::t('app', 'Created At'),
            'updated_at'    => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Подготовка данных для регистрации
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function prepareRegistration(array $params): array
    {
        return ArrayHelper::merge($params, [
            'status'     => User::STATUS_ACTIVE,
            'created_ip' => Yii::$app->request->remoteIP,
            'password'   => PasswordHelper::encrypt($params['password'])
        ]);
    }

    /**
     * Генерация токена
     *
     * @param int  $type
     * @param bool $expiring
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function generateToken(int $type, bool $expiring = true): void
    {
        if (!in_array($type, UserToken::$allowedTokens)) {
            throw new BadRequestHttpException(['token' => 'not found']);
        }

        $tokenData = [
            'user_id' => $this->id,
            'type'    => $type
        ];

        $token = UserToken::findOne($tokenData);

        if (is_null($token)) {
            $token = new UserToken();
        }

        $tokenData['token'] = Yii::$app->security->generateRandomString(34);

        if ($expiring) {
            $tokenData['expired_at'] = DateHelper::getTimestamp('+ 1 day');
        }

        $token->saveModel($tokenData);

        if ($type === UserToken::TYPE_AUTH_TOKEN) {
            $this->generateToken(UserToken::TYPE_RESET_AUTH_TOKEN);
        }
    }

    /**
     * Получить токен
     *
     * @param int $type
     * @return UserToken
     * @throws BadRequestHttpException
     */
    public function getToken(int $type): UserToken
    {
        if (!in_array($type, UserToken::$allowedTokens)) {
            throw new BadRequestHttpException(['token' => 'not found']);
        }

        $userToken = UserToken::findOne([
            'user_id' => $this->id,
            'type'    => $type
        ]);

        if (is_null($userToken)) {
            throw new BadRequestHttpException($userToken->getFirstErrors());
        }

        return $userToken;
    }

    /**
     * Валидация пароля
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword($password): bool
    {
        /** @var string $passwordWithSalt */
        $passwordWithSalt = PasswordHelper::addSaltInPassword($password);

        return Yii::$app->security->validatePassword($passwordWithSalt, $this->password);
    }

    /**
     * Update login info (ip and time)
     *
     * @return bool
     */
//    public function updateLoginMeta()
//    {
//        $this->logged_in_ip = Yii::$app->request->userIP;
//        $this->logged_in_at = gmdate('Y-m-d H:i:s');
//
//        return $this->save(false, ['logged_in_ip', 'logged_in_at']);
//    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): ?self
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param string $token
     * @param null   $type
     * @return User|null
     */
    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        $userToken = UserToken::findOne([
            'token' => $token,
            'type'  => UserToken::TYPE_AUTH_TOKEN
        ]);

        if (is_null($userToken)) {
            return null;
        }

        return static::findOne([
            'id'     => $userToken->user_id,
            'status' => self::STATUS_ACTIVE
        ]);
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
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(UserRole::class, ['id' => 'role_id']);
    }
}
