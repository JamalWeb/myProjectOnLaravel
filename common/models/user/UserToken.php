<?php

namespace common\models\user;

use api\modules\v1\models\error\BadRequestHttpException;
use common\components\DateHelper;
use Yii;
use common\models\base\BaseModel;
use yii\base\Exception;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_token".
 *
 * @property int    $id           Идентификатор токена
 * @property int    $user_id      Идентификатор пользователя
 * @property int    $type         Тип токена
 * @property string $assess_token Токен доступа
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
    const TYPE_EMAIL_ACTIVATE = 4;
    const TYPE_EMAIL_CHANGE = 5;

    public static $allowedTokens = [
        self::TYPE_AUTH,
        self::TYPE_RESET_AUTH,
        self::TYPE_PASSWORD_CHANGE,
        self::TYPE_EMAIL_ACTIVATE,
        self::TYPE_EMAIL_CHANGE,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'access_token'], 'required'],
            [['user_id', 'type'], 'default', 'value' => null],
            [['user_id', 'type'], 'integer'],
            [['expired_at', 'created_at', 'updated_at'], 'safe'],
            [['access_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'ID'),
            'user_id'      => Yii::t('app', 'User ID'),
            'type'         => Yii::t('app', 'Type'),
            'access_token' => Yii::t('app', 'Access token'),
            'expired_at'   => Yii::t('app', 'Expired At'),
            'created_at'   => Yii::t('app', 'Created At'),
            'updated_at'   => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Генерация токена
     *
     * @param User $user
     * @param int  $type
     * @param bool $expiring
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public static function generateAccessToken(User $user, int $type, string $expiring = ''): void
    {
        self::checkTypeAccessToken($type);

        $dataAccessToken = [
            'user_id' => $user->id,
            'type'    => $type
        ];

        $userToken = self::findOne($dataAccessToken);

        if (is_null($userToken)) {
            $userToken = new UserToken();
        }

        $dataAccessToken['access_token'] = Yii::$app->security->generateRandomString(34);

        if (!empty($expiring)) {
            $dataAccessToken['expired_at'] = DateHelper::getTimestamp($expiring);
        }

        $userToken->saveModel($dataAccessToken);

        if ($type === self::TYPE_AUTH) {
            self::generateAccessToken($user, self::TYPE_RESET_AUTH, '');
        }
    }

    /**
     * Получить токен
     *
     * @param User $user
     * @param int  $type
     * @return UserToken
     * @throws BadRequestHttpException
     */
    public static function getAccessToken(User $user, int $type): UserToken
    {
        self::checkTypeAccessToken($type);

        $userToken = UserToken::findOne([
            'user_id' => $user->id,
            'type'    => $type
        ]);

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
            throw new BadRequestHttpException(['access_token' => 'not found']);
        }
    }
}