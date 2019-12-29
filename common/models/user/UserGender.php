<?php

namespace common\models\user;

use common\components\ArrayHelper;
use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
        return TableRegistry::NAME_USER_GENDER;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID   => Yii::t('app', 'ID'),
            AttrRegistry::NAME => Yii::t('app', 'Name'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [AttrRegistry::NAME],
                'required'
            ],
            [
                [AttrRegistry::NAME],
                'string',
                'max' => 255
            ],
        ];
    }
}
