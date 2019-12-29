<?php

namespace common\models\user;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\DateHelper;
use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use Yii;
use common\models\base\BaseModel;
use yii\base\Exception;
use yii\db\ActiveQuery;

/**
 * @property int    $id           Идентификатор токена
 * @property int    $user_id      Идентификатор пользователя
 * @property int    $type         Тип токена
 * @property string $access_token Токен доступа
 * @property string $data         Временное хранение данных
 * @property string $expired_at   Срок действия
 * @property string $created_at   Дата создания
 * @property string $updated_at   Дата обновления
 * @property User   $user         Пользователь
 */
class UserToken extends BaseModel
{
    const TYPE_AUTH = 1;
    const TYPE_RESET_AUTH = 2;
    const TYPE_PASSWORD_CHANGE = 3;
    const TYPE_EMAIL_CONFIRM = 4;
    const TYPE_EMAIL_CHANGE = 5;
    const TYPE_USER_RECOVERY = 6;

    public static $allowedTokens = [
        self::TYPE_AUTH,
        self::TYPE_RESET_AUTH,
        self::TYPE_PASSWORD_CHANGE,
        self::TYPE_EMAIL_CONFIRM,
        self::TYPE_EMAIL_CHANGE,
        self::TYPE_USER_RECOVERY,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return TableRegistry::NAME_USER_TOKEN;
    }

    /**
     * Генерация токена
     *
     * @param User        $user
     * @param int         $typeId
     * @param string|null $data
     * @param string      $expiring
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public static function generateAccessToken(
        User $user,
        int $typeId,
        ?string $data = null,
        string $expiring = ''
    ): void {
        self::checkTypeAccessToken($typeId);

        $userToken = self::findOne(
            [
                AttrRegistry::USER_ID => $user->id,
                AttrRegistry::TYPE_ID => $typeId
            ]
        );

        if (is_null($userToken)) {
            $userToken = new UserToken(
                [
                    AttrRegistry::USER_ID => $user->id,
                    AttrRegistry::TYPE_ID => $typeId,
                    AttrRegistry::DATA    => $data
                ]
            );
        }

        $userToken->access_token = Yii::$app->security->generateRandomString(34);

        if (!empty($expiring)) {
            $userToken->expired_at = DateHelper::getTimestamp($expiring);
        }

        $userToken->saveModel();

        if ($typeId === self::TYPE_AUTH) {
            self::generateAccessToken($user, self::TYPE_RESET_AUTH, null, '');
        }
    }

    /**
     * Получить токен
     *
     * @param User $user
     * @param int  $typeId
     * @return UserToken
     * @throws BadRequestHttpException
     */
    public static function getAccessToken(User $user, int $typeId): UserToken
    {
        self::checkTypeAccessToken($typeId);

        $userToken = UserToken::findOne(
            [
                AttrRegistry::USER_ID => $user->id,
                AttrRegistry::TYPE_ID => $typeId
            ]
        );

        if (is_null($userToken)) {
            throw new BadRequestHttpException($userToken->getFirstErrors());
        }

        return $userToken;
    }

    /**
     * Проверка типа токена
     *
     * @param int $type
     * @throws BadRequestHttpException
     */
    public static function checkTypeAccessToken(int $type): void
    {
        if (!in_array($type, self::$allowedTokens)) {
            throw new BadRequestHttpException(
                [
                    AttrRegistry::ACCESS_TOKEN => 'not found'
                ]
            );
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(
            User::class,
            [
                AttrRegistry::ID => AttrRegistry::USER_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID           => Yii::t('app', 'ID'),
            AttrRegistry::USER_ID      => Yii::t('app', 'User ID'),
            AttrRegistry::TYPE_ID      => Yii::t('app', 'Type ID'),
            AttrRegistry::ACCESS_TOKEN => Yii::t('app', 'Access token'),
            AttrRegistry::DATA         => Yii::t('app', 'Data'),
            AttrRegistry::EXPIRED_AT   => Yii::t('app', 'Expired At'),
            AttrRegistry::CREATED_AT   => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT   => Yii::t('app', 'Updated At'),
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
                    AttrRegistry::USER_ID,
                    AttrRegistry::TYPE_ID,
                    AttrRegistry::ACCESS_TOKEN
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::TYPE_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    AttrRegistry::USER_ID,
                    AttrRegistry::TYPE_ID
                ],
                'integer'
            ],
            [
                ['data'],
                'string'
            ],
            [
                [
                    AttrRegistry::EXPIRED_AT,
                    AttrRegistry::CREATED_AT,
                    AttrRegistry::UPDATED_AT
                ],
                'safe'
            ],
            [
                [AttrRegistry::ACCESS_TOKEN],
                'string',
                'max' => 255
            ],
        ];
    }
}
