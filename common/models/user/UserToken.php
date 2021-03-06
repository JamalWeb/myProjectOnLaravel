<?php

namespace common\models\user;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\DateHelper;
use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\components\registry\RgUser;
use common\models\base\BaseModel;
use Yii;
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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_USER_TOKEN;
    }

    /**
     * Получить токен
     *
     * @param User $user
     * @param int  $typeId
     * @return UserToken
     * @throws BadRequestHttpException
     */
    public static function get(User $user, int $typeId): UserToken
    {
        self::checkTypeAccessToken($typeId);

        $userToken = self::findOne(
            [
                RgAttribute::USER_ID => $user->id,
                RgAttribute::TYPE_ID => $typeId
            ]
        );

        if ($userToken === null) {
            throw new BadRequestHttpException([]);
        }

        return $userToken;
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
                RgAttribute::USER_ID => $user->id,
                RgAttribute::TYPE_ID => $typeId
            ]
        );

        if ($userToken === null) {
            $userToken = new self(
                [
                    RgAttribute::USER_ID => $user->id,
                    RgAttribute::TYPE_ID => $typeId,
                    RgAttribute::DATA    => $data
                ]
            );
        }

        $userToken->access_token = Yii::$app->security->generateRandomString(34);

        if (!empty($expiring)) {
            $userToken->expired_at = DateHelper::getTimestamp($expiring);
        }

        $userToken->saveModel();

        if ($typeId === RgUser::TOKEN_TYPE_AUTH) {
            self::generateAccessToken($user, RgUser::TOKEN_TYPE_RESET_AUTH, null, '');
        }
    }

    /**
     * Проверка типа токена
     *
     * @param int $type
     * @throws BadRequestHttpException
     */
    public static function checkTypeAccessToken(int $type): void
    {
        if (!in_array($type, RgUser::$tokenTypeList, true)) {
            throw new BadRequestHttpException(
                [
                    RgAttribute::ACCESS_TOKEN => 'not found'
                ]
            );
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(
            User::class,
            [
                RgAttribute::ID => RgAttribute::USER_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID           => Yii::t('app', 'ID'),
            RgAttribute::USER_ID      => Yii::t('app', 'User ID'),
            RgAttribute::TYPE_ID      => Yii::t('app', 'Type ID'),
            RgAttribute::ACCESS_TOKEN => Yii::t('app', 'Access token'),
            RgAttribute::DATA         => Yii::t('app', 'Data'),
            RgAttribute::EXPIRED_AT   => Yii::t('app', 'Expired At'),
            RgAttribute::CREATED_AT   => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT   => Yii::t('app', 'Updated At'),
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
                    RgAttribute::USER_ID,
                    RgAttribute::TYPE_ID,
                    RgAttribute::ACCESS_TOKEN
                ],
                'required'
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::TYPE_ID
                ],
                'default',
                'value' => null
            ],
            [
                [
                    RgAttribute::USER_ID,
                    RgAttribute::TYPE_ID
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::DATA
                ],
                'string'
            ],
            [
                [
                    RgAttribute::EXPIRED_AT,
                    RgAttribute::CREATED_AT,
                    RgAttribute::UPDATED_AT
                ],
                'safe'
            ],
            [
                [
                    RgAttribute::ACCESS_TOKEN
                ],
                'string',
                'max' => 255
            ],
        ];
    }
}
