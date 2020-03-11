<?php

namespace common\models\user;

use common\components\ArrayHelper;
use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\models\base\BaseModel;
use Yii;
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
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'timestamp' => [
                    'class'              => TimestampBehavior::class,
                    'createdAtAttribute' => false,
                    'updatedAtAttribute' => false,
                    'value'              => gmdate('Y-m-d H:i:s'),
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_USER_GENDER;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID   => Yii::t('app', 'ID'),
            RgAttribute::NAME => Yii::t('app', 'Name'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [RgAttribute::NAME],
                'required'
            ],
            [
                [RgAttribute::NAME],
                'string',
                'max' => 255
            ],
        ];
    }
}
