<?php

namespace common\models\user;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "gender".
 *
 * @property int    $id
 * @property string $name
 */
class Gender extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gender';
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
            'id'   => Yii::t('children', 'ID'),
            'name' => Yii::t('children', 'Name'),
        ];
    }
}
