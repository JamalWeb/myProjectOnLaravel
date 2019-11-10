<?php

namespace common\models\relations;

use common\models\base\BaseModel;
use common\models\Interest;
use common\models\user\User;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "relation_user_interest".
 *
 * @property int      $id          Идентификатор связи пользователя с его интересами
 * @property int      $user_id     Идентификатор пользователя
 * @property int      $interest_id Идентификатор интереса
 * @property string   $created_at  Дата создания
 * @property string   $updated_at  Дата обновления
 * @property Interest $interest
 * @property User     $user
 */
class RelationUserInterest extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relation_user_interest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'interest_id'], 'required'],
            [['user_id', 'interest_id'], 'default', 'value' => null],
            [['user_id', 'interest_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['interest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Interest::class, 'targetAttribute' => ['interest_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'user_id'     => Yii::t('app', 'User ID'),
            'interest_id' => Yii::t('app', 'Interest ID'),
            'created_at'  => Yii::t('app', 'Created At'),
            'updated_at'  => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getInterest()
    {
        return $this->hasOne(Interest::class, ['id' => 'interest_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
