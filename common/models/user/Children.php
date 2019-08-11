<?php

namespace common\models\user;

use common\models\system\BaseModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "children".
 *
 * @property int  $id              Идентификатор ребенка
 * @property int  $age             Возраст ребенка
 * @property int  $user_id         Идентификатор родителя
 * @property int  $gender_id       Пол ребенка
 * @property int  $created_at      Дата создания
 * @property int  $updated_at      Дата последнего обновления
 * @property User $parent          Родитель
 */
class Children extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'children';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'age', 'gender_id'], 'required'],
            [['user_id', 'age', 'gender_id'], 'integer'],
            [
                ['gender_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Gender::class,
                'targetAttribute' => ['gender_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('app', 'ID'),
            'user_id'   => Yii::t('app', 'User ID'),
            'age'       => Yii::t('app', 'Age'),
            'gender_id' => Yii::t('app', 'Gender ID'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
