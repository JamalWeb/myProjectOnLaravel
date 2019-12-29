<?php

namespace common\models\user;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\PasswordHelper;
use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use common\components\registry\UserRegistry;
use common\models\base\BaseModel;
use Yii;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * @property int            $id                Идентификатор пользователя
 * @property int            $type_id           Идентификатор типа
 * @property int            $role_id           Идентификатор роли
 * @property string         $email             Электронная почта
 * @property string         $username          Никнейм
 * @property string         $password          Пароль
 * @property string         $auth_key          Ключ необходимый для авторизации
 * @property bool           $status_id         Статус активности (1 - вкл. 0 - выкл.) | default = 1
 * @property string         $logged_in_ip      IP адрес авторизации
 * @property string         $logged_in_at      Дата авторизации
 * @property string         $logout_in_ip      IP адрес выхода
 * @property string         $logout_in_at      Дата выхода
 * @property string         $created_ip        IP адрес с которого создали
 * @property bool           $is_banned         Бан (1 - вкл. 0 - выкл.) | default = 0
 * @property string         $banned_reason     Причина бана
 * @property string         $banned_at         Дата бана
 * @property string         $created_at        Дата создания
 * @property string         $authKey
 * @property string         $updated_at        Дата обновления
 * @property array          $publicInfo        Информация о пользователи
 * @property UserType       $type              Тип
 * @property UserRole       $role              Роль
 * @property UserProfile    $profile           Профиль
 * @property UserChildren[] $children          Дети
 * @property string         $fullName          Полное имя
 */
class User extends BaseModel implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableRegistry::NAME_USER;
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
     * Проверка типа пользователя
     *
     * @param int $type
     * @return bool
     * @throws BadRequestHttpException
     */
    public function checkType(int $type): bool
    {
        if ($this->type_id == $type) {
            throw new BadRequestHttpException(
                [
                    AttrRegistry::TYPE_ID => 'Type is invalid'
                ]
            );
        }

        return true;
    }

    /**
     * @return array
     */
    public function getPublicInfo(): array
    {
        $defaultUserInfo = [
            AttrRegistry::ID         => $this->id,
            AttrRegistry::EMAIL      => $this->email,
            AttrRegistry::STATUS     => [
                AttrRegistry::ID   => $this->status_id,
                AttrRegistry::NAME => UserRegistry::getStatusNameById($this->status)
            ],
            AttrRegistry::BANNED     => [
                AttrRegistry::IS_BANNED     => $this->is_banned,
                AttrRegistry::BANNED_REASON => $this->banned_reason,
                AttrRegistry::BANNED_AT     => $this->banned_at,
            ],
            AttrRegistry::PROFILE    => [
                AttrRegistry::FIRST_NAME   => $this->profile->first_name,
                AttrRegistry::LAST_NAME    => $this->profile->last_name,
                AttrRegistry::PHONE_NUMBER => $this->profile->phone_number,
                AttrRegistry::ADDRESS      => $this->profile->address,
                AttrRegistry::ABOUT        => $this->profile->about,
                AttrRegistry::COUNTRY      => null,
                AttrRegistry::CITY         => [
                    AttrRegistry::ID   => $this->profile->city->id,
                    AttrRegistry::NAME => $this->profile->city->name
                ],
                AttrRegistry::CHILDREN     => [],
                AttrRegistry::TYPE         => [
                    AttrRegistry::ID          => $this->type->id,
                    AttrRegistry::NAME        => $this->type->name,
                    AttrRegistry::DESCRIPTION => $this->type->description
                ],
                AttrRegistry::LONGITUDE    => $this->profile->longitude,
                AttrRegistry::LATITUDE     => $this->profile->latitude,
                AttrRegistry::LANGUAGE     => $this->profile->language,
                AttrRegistry::SHORT_LANG   => $this->profile->short_lang,
                AttrRegistry::TIMEZONE     => $this->profile->timezone,
            ],
            AttrRegistry::CREATED_AT => $this->created_at
        ];

        if (!empty($this->children) && $this->type_id == UserType::TYPE_DEFAULT_USER) {
            /** @var UserChildren $child */
            foreach (ArrayHelper::generator($this->children) as $child) {
                $defaultUserInfo[AttrRegistry::PROFILE][AttrRegistry::CHILDREN][] = [
                    AttrRegistry::ID     => $child->id,
                    AttrRegistry::AGE    => $child->age,
                    AttrRegistry::GENDER => [
                        AttrRegistry::ID   => $child->gender->id,
                        AttrRegistry::NAME => $child->gender->name
                    ]
                ];
            }
        }

        return $defaultUserInfo;
    }

    public function getFullName(): string
    {
        return "{$this->profile->first_name} {$this->profile->last_name}";
    }

    /**
     * @return ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(
            UserType::class,
            [
                AttrRegistry::ID => AttrRegistry::TYPE_ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(
            UserRole::class,
            [
                AttrRegistry::ID => AttrRegistry::ROLE_ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(
            UserProfile::class,
            [
                AttrRegistry::USER_ID => AttrRegistry::ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(
            UserChildren::class,
            [
                AttrRegistry::USER_ID => AttrRegistry::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID            => Yii::t('app', 'ID'),
            AttrRegistry::TYPE_ID       => Yii::t('app', 'Type ID'),
            AttrRegistry::ROLE_ID       => Yii::t('app', 'Role ID'),
            AttrRegistry::EMAIL         => Yii::t('app', 'Email'),
            AttrRegistry::USERNAME      => Yii::t('app', 'Username'),
            AttrRegistry::PASSWORD      => Yii::t('app', 'Password'),
            AttrRegistry::AUTH_KEY      => Yii::t('app', 'Auth Key'),
            AttrRegistry::STATUS_ID     => Yii::t('app', 'Status ID'),
            AttrRegistry::LOGGED_IN_IP  => Yii::t('app', 'Logged In Ip'),
            AttrRegistry::LOGGED_IN_AT  => Yii::t('app', 'Logged In At'),
            AttrRegistry::LOGOUT_IN_IP  => Yii::t('app', 'Logout In Ip'),
            AttrRegistry::LOGOUT_IN_AT  => Yii::t('app', 'Logout In At'),
            AttrRegistry::CREATED_IP    => Yii::t('app', 'Created Ip'),
            AttrRegistry::IS_BANNED     => Yii::t('app', 'Is Banned'),
            AttrRegistry::BANNED_REASON => Yii::t('app', 'Banned Reason'),
            AttrRegistry::BANNED_AT     => Yii::t('app', 'Banned At'),
            AttrRegistry::CREATED_AT    => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT    => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    AttrRegistry::TYPE_ID,
                    AttrRegistry::ROLE_ID,
                    AttrRegistry::EMAIL,
                    AttrRegistry::PASSWORD
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::TYPE_ID,
                    AttrRegistry::ROLE_ID,
                    AttrRegistry::STATUS_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    AttrRegistry::TYPE_ID,
                    AttrRegistry::ROLE_ID,
                    AttrRegistry::STATUS_ID
                ],
                'integer'
            ],
            [
                [
                    AttrRegistry::LOGGED_IN_AT,
                    AttrRegistry::LOGOUT_IN_AT,
                    AttrRegistry::BANNED_AT,
                    AttrRegistry::CREATED_AT,
                    AttrRegistry::UPDATED_AT
                ],
                'safe'
            ],
            [
                [AttrRegistry::IS_BANNED],
                'boolean'
            ],
            [
                [
                    AttrRegistry::EMAIL,
                    AttrRegistry::USERNAME,
                    AttrRegistry::PASSWORD,
                    AttrRegistry::AUTH_KEY,
                    AttrRegistry::LOGGED_IN_IP,
                    AttrRegistry::LOGOUT_IN_IP,
                    AttrRegistry::CREATED_IP,
                    AttrRegistry::BANNED_REASON
                ],
                'string',
                'max' => 255
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): ?self
    {
        return static::findOne(
            [
                AttrRegistry::ID        => $id,
                AttrRegistry::STATUS_ID => UserRegistry::USER_STATUS_ACTIVE,
                AttrRegistry::IS_BANNED => false
            ]
        );
    }

    /**
     * @param      $accessToken
     * @param null $type
     * @return User|null
     */
    public static function findIdentityByAccessToken($accessToken, $type = null): ?User
    {
        $userToken = UserToken::findOne(
            [
                AttrRegistry::ACCESS_TOKEN => $accessToken,
                AttrRegistry::TYPE_ID      => UserToken::TYPE_AUTH
            ]
        );

        if (is_null($userToken)) {
            return null;
        }

        return static::findOne(
            [
                AttrRegistry::ID        => $userToken->user_id,
                AttrRegistry::STATUS_ID => [
                    UserRegistry::USER_STATUS_ACTIVE,
                    UserRegistry::USER_STATUS_UNCONFIRMED_EMAIL
                ]
            ]
        );
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
}
