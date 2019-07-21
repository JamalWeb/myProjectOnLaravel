<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_token".
 *
 * @property int    $id
 * @property int    $user_id
 * @property int    $type
 * @property string $token
 * @property string $data
 * @property string $created_at
 * @property string $expired_at
 * @property User   $user
 */
class UserToken extends \amnah\yii2\user\models\UserToken
{
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
