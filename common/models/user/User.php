<?php

namespace common\models\user;

use common\components\ArrayHelper;
use common\components\PassHelper;
use common\models\system\BaseModel;
use Exception;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int         $id
 * @property int         $role_id
 * @property int         $status
 * @property string      $email
 * @property string      $username
 * @property string      $password
 * @property string      $auth_key
 * @property string      $access_token
 * @property string      $logged_in_ip
 * @property string      $logged_in_at
 * @property string      $created_ip
 * @property string      $created_at
 * @property string      $updated_at
 * @property string      $banned_at
 * @property string      $banned_reason
 * @property int         $type_id      Идентификатор типа пользователя
 * @property bool        $is_banned    Бан (1 - вкл. 0 - выкл.) | default = 0
 * @property string      $logout_in_at Дата выхода
 * @property Profile[]   $profiles
 * @property Role        $role
 * @property UserAuth[]  $userAuths
 * @property string      $authKey
 * @property UserToken[] $userTokens
 */
class User extends BaseModel implements IdentityInterface
{
    /** @var int Inactive status */
    const STATUS_INACTIVE = 0;

    /** @var int Active status */
    const STATUS_ACTIVE = 1;

    /** @var int Unconfirmed email status */
    const STATUS_UNCONFIRMED_EMAIL = 2;

    const SCENARIO_CREATE_USER = 'create_user_account';
    const SCENARIO_CREATE_BUSINESS_USER = 'create_business_account';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
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
        $passHelper = new PassHelper();

        return ArrayHelper::merge($params, [
            'status'     => User::STATUS_UNCONFIRMED_EMAIL,
            'created_ip' => Yii::$app->request->remoteIP,
            'password'   => $passHelper->encrypt($params['password'])
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserAuths()
    {
        return $this->hasMany(UserAuth::class, ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param      $token
     * @param null $type
     * @return User|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'access_token' => $token,
            'status'       => self::STATUS_ACTIVE
        ]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status'             => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
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
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'status'], 'required'],
            [['email'], 'required', 'on' => self::SCENARIO_CREATE_USER],
            [['role_id', 'status', 'type_id'], 'default', 'value' => null],
            [['role_id', 'status', 'type_id'], 'integer'],
            [['logged_in_at', 'created_at', 'updated_at', 'banned_at', 'logout_in_at'], 'safe'],
            [['is_banned'], 'boolean'],
            [['email', 'username', 'password', 'auth_key', 'access_token', 'logged_in_ip', 'created_ip', 'banned_reason'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * Update login info (ip and time)
     *
     * @return bool
     */
    public function updateLoginMeta()
    {
        $this->logged_in_ip = Yii::$app->request->userIP;
        $this->logged_in_at = gmdate("Y-m-d H:i:s");

        return $this->save(false, ["logged_in_ip", "logged_in_at"]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('api', 'ID'),
            'role_id'       => Yii::t('api', 'Role ID'),
            'status'        => Yii::t('api', 'Status'),
            'email'         => Yii::t('api', 'Email'),
            'username'      => Yii::t('api', 'Username'),
            'password'      => Yii::t('api', 'Password'),
            'auth_key'      => Yii::t('api', 'Auth Key'),
            'access_token'  => Yii::t('api', 'Access Token'),
            'logged_in_ip'  => Yii::t('api', 'Logged In Ip'),
            'logged_in_at'  => Yii::t('api', 'Logged In At'),
            'created_ip'    => Yii::t('api', 'Created Ip'),
            'created_at'    => Yii::t('api', 'Created At'),
            'updated_at'    => Yii::t('api', 'Updated At'),
            'banned_at'     => Yii::t('api', 'Banned At'),
            'banned_reason' => Yii::t('api', 'Banned Reason'),
            'type_id'       => Yii::t('api', 'Type ID'),
            'is_banned'     => Yii::t('api', 'Is Banned'),
            'logout_in_at'  => Yii::t('api', 'Logout In At'),
        ];
    }
}
