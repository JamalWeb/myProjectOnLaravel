<?php

namespace common\models\user;

use common\components\ArrayHelper;
use common\components\registry\Constants;
use Yii;
use common\models\base\BaseModel;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_gender".
 *
 * @property int    $id   Идентификатор пола
 * @property string $name Наименование пола
 */
class UserGender extends BaseModel
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'updatedAtAttribute' => false,
                'value'              => gmdate('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return Constants::TABLE_NAME_USER_GENDER;
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
