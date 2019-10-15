<?php

namespace common\models\user;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "user_gender".
 *
 * @property int    $id   Идентификатор пола
 * @property string $name Наименование пола
 */
class UserGender extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_gender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'   => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
