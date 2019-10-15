<?php

namespace common\models\user;

use Yii;
use common\models\base\BaseModel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_children".
 *
 * @property int    $id              Идентификатор ребенка пользователя
 * @property int    $user_id         Идентификатор пользователя
 * @property int    $age             Возраст
 * @property string $gender_id       Идентификатор пола
 * @property string $created_at      Дата создания
 * @property string $updated_at      Дата обновления
 * @property User   $parent          Родитель
 */
class UserChildren extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_children';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'age', 'gender_id'], 'required'],
            [['user_id', 'age'], 'default', 'value' => null],
            [['user_id', 'age'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['gender_id'], 'string', 'max' => 255],
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
            'age'        => Yii::t('app', 'Age'),
            'gender_id'  => Yii::t('app', 'Gender ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
