<?php

namespace common\models\user;

use common\components\ArrayHelper;
use Yii;
use common\components\DateHelper;
use common\models\system\BaseModel;
use yii\behaviors\TimestampBehavior;

/**
 * Class UserToken
 *
 * @package common\models\user
 * @property string $id         [integer]
 * @property string $user_id    [integer]
 * @property int    $type       [smallint]
 * @property string $token      [varchar(255)]
 * @property string $data       [varchar(255)]
 * @property int    $created_at [timestamp(0)]
 * @property int    $expired_at [timestamp(0)]
 */
class UserToken extends BaseModel
{
    const TYPE_AUTH_TOKEN = 1;
    const TYPE_RESET_AUTH_TOKEN = 2;
    const TYPE_PASSWORD_CHANGE = 3;
    const TYPE_EMAIL_ACTIVATE = 4;
    const TYPE_EMAIL_CHANGE = 5;

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value'              => DateHelper::getTimestamp(),
            ],
        ]);
    }

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
            [['user_id', 'type'], 'default', 'value' => null],
            [['user_id', 'type'], 'integer'],
            [['type', 'token'], 'required'],
            [['created_at', 'expired_at'], 'safe'],
            [['token', 'data'], 'string', 'max' => 255],
            [['token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('api', 'ID'),
            'user_id'    => Yii::t('api', 'User ID'),
            'type'       => Yii::t('api', 'Type'),
            'token'      => Yii::t('api', 'Token'),
            'data'       => Yii::t('api', 'Data'),
            'created_at' => Yii::t('api', 'Created At'),
            'expired_at' => Yii::t('api', 'Expired At'),
        ];
    }
}
