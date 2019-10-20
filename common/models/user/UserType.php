<?php

namespace common\models\user;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "user_type".
 *
 * @property int    $id         Идентификатор типа
 * @property string $name       Наименование
 * @property string $desc       Описание
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 */
class UserType extends BaseModel
{
    const TYPE_SYSTEM = 1;
    const TYPE_DEFAULT_USER = 2;
    const TYPE_BUSINESS_USER = 3;

    public static $validTypeSearch = [
        self::TYPE_DEFAULT_USER,
        self::TYPE_BUSINESS_USER,
    ];

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
