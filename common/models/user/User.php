<?php

namespace common\models\user;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\ArrayHelper;
use common\components\PasswordHelper;
use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\components\registry\RgUser;
use common\models\base\BaseModel;
use Yii;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;

/**
 * @property int            $id                  Идентификатор пользователя
 * @property int            $type_id             Идентификатор типа
 * @property int            $role_id             Идентификатор роли
 * @property string         $email               Электронная почта
 * @property string         $username            Никнейм
 * @property string         $password            Пароль
 * @property string         $auth_key            Ключ необходимый для авторизации
 * @property bool           $status_id           Статус активности (1 - вкл. 0 - выкл.) | default = 1
 * @property string         $logged_in_ip        IP адрес авторизации
 * @property string         $logged_in_at        Дата авторизации
 * @property string         $logout_in_ip        IP адрес выхода
 * @property string         $logout_in_at        Дата выхода
 * @property string         $created_ip          IP адрес с которого создали
 * @property bool           $is_banned           Бан (1 - вкл. 0 - выкл.) | default = 0
 * @property string         $banned_reason       Причина бана
 * @property string         $banned_at           Дата бана
 * @property string         $created_at          Дата создания
 * @property string         $authKey
 * @property string         $updated_at          Дата обновления
 * @property array          $publicInfo          Информация о пользователи
 * @property UserStatus     $status              Тип
 * @property UserType       $type                Тип
 * @property UserRole       $role                Роль
 * @property UserProfile    $profile             Профиль
 * @property UserChildren[] $children            Дети
 * @property string         $fullName            Полное имя
 */
class User extends BaseModel implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_USER;
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
                    RgAttribute::TYPE_ID => 'Type is invalid'
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
            RgAttribute::ID      => $this->id,
            RgAttribute::EMAIL   => $this->email,
            RgAttribute::ACCESS  => [],
            RgAttribute::PROFILE => [
                RgAttribute::FIRST_NAME   => $this->profile->first_name,
                RgAttribute::LAST_NAME    => $this->profile->last_name,
                RgAttribute::PHONE_NUMBER => $this->profile->phone_number,
                RgAttribute::ADDRESS      => $this->profile->address,
                RgAttribute::ABOUT        => $this->profile->about,
                RgAttribute::COUNTRY      => null,
                RgAttribute::CITY         => [
                    RgAttribute::ID   => $this->profile->city->id,
                    RgAttribute::NAME => $this->profile->city->name
                ],
                RgAttribute::CHILDREN     => [],
                RgAttribute::TYPE    => [
                    RgAttribute::ID          => $this->type->id,
                    RgAttribute::NAME        => $this->type->name,
                    RgAttribute::DESCRIPTION => $this->type->description
                ],
                RgAttribute::LONGITUDE    => $this->profile->longitude,
                RgAttribute::LATITUDE     => $this->profile->latitude,
                RgAttribute::LANGUAGE     => $this->profile->language,
                RgAttribute::SHORT_LANG   => $this->profile->short_lang,
                RgAttribute::TIMEZONE     => $this->profile->timezone,
            ],
            RgAttribute::BANNED  => [
                RgAttribute::IS_BANNED     => $this->is_banned,
                RgAttribute::BANNED_REASON => $this->banned_reason,
                RgAttribute::BANNED_AT     => $this->banned_at
            ]
        ];

        if (!empty($this->children) && $this->type_id == RgUser::TYPE_DEFAULT) {
            /** @var UserChildren $child */
            foreach (ArrayHelper::generator($this->children) as $child) {
                $defaultUserInfo[RgAttribute::PROFILE][RgAttribute::CHILDREN][] = [
                    RgAttribute::ID     => $child->id,
                    RgAttribute::AGE    => $child->age,
                    RgAttribute::GENDER => [
                        RgAttribute::ID   => $child->gender->id,
                        RgAttribute::NAME => $child->gender->name
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
    public function getStatus()
    {
        return $this->hasOne(
            UserStatus::class,
            [
                RgAttribute::ID => RgAttribute::STATUS_ID
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(
            UserType::class,
            [
                RgAttribute::ID => RgAttribute::TYPE_ID
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
                RgAttribute::ID => RgAttribute::ROLE_ID
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
                RgAttribute::USER_ID => RgAttribute::ID
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
                RgAttribute::USER_ID => RgAttribute::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID            => Yii::t('app', 'ID'),
            RgAttribute::TYPE_ID       => Yii::t('app', 'Type ID'),
            RgAttribute::ROLE_ID       => Yii::t('app', 'Role ID'),
            RgAttribute::EMAIL         => Yii::t('app', 'Email'),
            RgAttribute::USERNAME      => Yii::t('app', 'Username'),
            RgAttribute::PASSWORD      => Yii::t('app', 'Password'),
            RgAttribute::AUTH_KEY      => Yii::t('app', 'Auth Key'),
            RgAttribute::STATUS_ID     => Yii::t('app', 'Status ID'),
            RgAttribute::LOGGED_IN_IP  => Yii::t('app', 'Logged In Ip'),
            RgAttribute::LOGGED_IN_AT  => Yii::t('app', 'Logged In At'),
            RgAttribute::LOGOUT_IN_IP  => Yii::t('app', 'Logout In Ip'),
            RgAttribute::LOGOUT_IN_AT  => Yii::t('app', 'Logout In At'),
            RgAttribute::CREATED_IP    => Yii::t('app', 'Created Ip'),
            RgAttribute::IS_BANNED     => Yii::t('app', 'Is Banned'),
            RgAttribute::BANNED_REASON => Yii::t('app', 'Banned Reason'),
            RgAttribute::BANNED_AT     => Yii::t('app', 'Banned At'),
            RgAttribute::CREATED_AT    => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT    => Yii::t('app', 'Updated At'),
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
                    RgAttribute::TYPE_ID,
                    RgAttribute::ROLE_ID,
                    RgAttribute::EMAIL,
                    RgAttribute::PASSWORD
                ],
                'required'
            ],
            [
                [
                    RgAttribute::TYPE_ID,
                    RgAttribute::ROLE_ID,
                    RgAttribute::STATUS_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    RgAttribute::TYPE_ID,
                    RgAttribute::ROLE_ID,
                    RgAttribute::STATUS_ID
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::LOGGED_IN_AT,
                    RgAttribute::LOGOUT_IN_AT,
                    RgAttribute::BANNED_AT,
                    RgAttribute::CREATED_AT,
                    RgAttribute::UPDATED_AT
                ],
                'safe'
            ],
            [
                [RgAttribute::IS_BANNED],
                'boolean'
            ],
            [
                [
                    RgAttribute::EMAIL,
                    RgAttribute::USERNAME,
                    RgAttribute::PASSWORD,
                    RgAttribute::AUTH_KEY,
                    RgAttribute::LOGGED_IN_IP,
                    RgAttribute::LOGOUT_IN_IP,
                    RgAttribute::CREATED_IP,
                    RgAttribute::BANNED_REASON
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
                RgAttribute::ID        => $id,
                RgAttribute::STATUS_ID => RgUser::STATUS_ACTIVE,
                RgAttribute::IS_BANNED => false
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
                RgAttribute::ACCESS_TOKEN => $accessToken,
                RgAttribute::TYPE_ID      => RgUser::TOKEN_TYPE_AUTH
            ]
        );

        if (is_null($userToken)) {
            return null;
        }

        return static::findOne(
            [
                RgAttribute::ID        => $userToken->user_id,
                RgAttribute::STATUS_ID => [
                    RgUser::STATUS_ACTIVE,
                    RgUser::STATUS_UNCONFIRMED_EMAIL
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
