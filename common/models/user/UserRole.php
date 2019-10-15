<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property int    $id         Идентификатор роли
 * @property string $name       Наименование роли
 * @property string $desc       Описание роли
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 */
class UserRole extends \yii\db\ActiveRecord
{
    const ROLE_ADMIN = 1;
    const ROLE_DEFAULT_USER = 2;
    const ROLE_BUSINESS_USER = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'desc'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'name'       => Yii::t('app', 'Name'),
            'desc'       => Yii::t('app', 'Desc'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
