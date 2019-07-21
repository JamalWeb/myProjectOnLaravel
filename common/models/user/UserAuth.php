<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_auth".
 *
 * @property int    $id
 * @property int    $user_id
 * @property string $provider
 * @property string $provider_id
 * @property string $provider_attributes
 * @property string $created_at
 * @property string $updated_at
 * @property User   $user
 */
class UserAuth extends \amnah\yii2\user\models\UserAuth
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'provider', 'provider_id', 'provider_attributes'], 'required'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['provider_attributes'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['provider', 'provider_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                  => Yii::t('api', 'ID'),
            'user_id'             => Yii::t('api', 'User ID'),
            'provider'            => Yii::t('api', 'Provider'),
            'provider_id'         => Yii::t('api', 'Provider ID'),
            'provider_attributes' => Yii::t('api', 'Provider Attributes'),
            'created_at'          => Yii::t('api', 'Created At'),
            'updated_at'          => Yii::t('api', 'Updated At'),
        ];
    }
}
