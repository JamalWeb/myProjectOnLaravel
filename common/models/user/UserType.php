<?php

namespace common\models\user;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_type".
 *
 * @property int    $id   Идентификатор типа пользователя
 * @property string $name Название
 * @property string $desc Описание
 */
class UserType extends ActiveRecord
{
    const TYPE_SYSTEM = 1;
    const TYPE_USER = 2;
    const TYPE_BUSINESS_USER = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'   => Yii::t('api', 'ID'),
            'name' => Yii::t('api', 'Name'),
            'desc' => Yii::t('api', 'Desc'),
        ];
    }
}
