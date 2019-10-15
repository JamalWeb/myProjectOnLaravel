<?php

namespace common\models\user;

use Yii;
use common\models\base\BaseModel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_token".
 *
 * @property int    $id         Идентификатор токена
 * @property int    $user_id    Идентификатор пользователя
 * @property int    $type       Тип токена
 * @property string $token      Токен
 * @property string $expired_at Срок действия
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 * @property User   $user       Пользователь
 */
class UserToken extends BaseModel
{
    const TYPE_AUTH_TOKEN = 1;
    const TYPE_RESET_AUTH_TOKEN = 2;
    const TYPE_PASSWORD_CHANGE = 3;
    const TYPE_EMAIL_ACTIVATE = 4;
    const TYPE_EMAIL_CHANGE = 5;

    public static $allowedTokens = [
        self::TYPE_AUTH_TOKEN,
        self::TYPE_RESET_AUTH_TOKEN,
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
            [['user_id'], 'required'],
            [['user_id', 'type'], 'default', 'value' => null],
            [['user_id', 'type'], 'integer'],
            [['expired_at', 'created_at', 'updated_at'], 'safe'],
            [['token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'user_id'    => Yii::t('app', 'User ID'),
            'type'       => Yii::t('app', 'Type'),
            'token'      => Yii::t('app', 'Token'),
            'expired_at' => Yii::t('app', 'Expired At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
