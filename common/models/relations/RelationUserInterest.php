<?php

namespace common\models\relations;

use common\models\base\BaseModel;
use common\models\InterestCategory;
use common\models\user\User;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "relation_user_interest".
 *
 * @property int              $id                   Идентификатор связи пользователя с его интересами
 * @property int              $user_id              Идентификатор пользователя
 * @property int              $interest_category_id Идентификатор интереса
 * @property string           $created_at           Дата создания
 * @property string           $updated_at           Дата обновления
 * @property InterestCategory $interest
 * @property User             $user
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
            [['user_id', 'interest_category_id'], 'required'],
            [['user_id', 'interest_category_id'], 'default', 'value' => null],
            [['user_id', 'interest_category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['interest_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterestCategory::class, 'targetAttribute' => ['interest_category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('app', 'ID'),
            'user_id'              => Yii::t('app', 'User ID'),
            'interest_category_id' => Yii::t('app', 'Interest Category ID'),
            'created_at'           => Yii::t('app', 'Created At'),
            'updated_at'           => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getInterest()
    {
        return $this->hasOne(InterestCategory::class, ['id' => 'interest_category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
