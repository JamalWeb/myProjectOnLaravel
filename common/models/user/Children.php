<?php

namespace common\models\user;

use common\models\system\BaseModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "children".
 *
 * @property int    $id      Идентификатор ребенка пользователя
 * @property int    $user_id Идентификатор пользователя
 * @property int    $age     Возраст ребенка
 * @property string $gender  Пол ребенка
 * @property User   $parent  Родитель
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
            [['user_id', 'age', 'gender'], 'required'],
            [['user_id', 'age'], 'integer'],
            [['gender'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'      => Yii::t('children', 'ID'),
            'user_id' => Yii::t('children', 'User ID'),
            'age'     => Yii::t('children', 'Age'),
            'gender'  => Yii::t('children', 'Gender'),
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
