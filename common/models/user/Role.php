<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int    $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property int    $can_admin
 * @property User[] $users
 */
class Role extends \amnah\yii2\user\models\Role
{
    /**
     * @var int Default user role
     */
    const ROLE_BUSINESS_USER = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['can_admin'], 'default', 'value' => null],
            [['can_admin'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('api', 'ID'),
            'name'       => Yii::t('api', 'Name'),
            'created_at' => Yii::t('api', 'Created At'),
            'updated_at' => Yii::t('api', 'Updated At'),
            'can_admin'  => Yii::t('api', 'Can Admin'),
        ];
    }
}
