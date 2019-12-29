<?php

namespace common\models;

use common\components\ArrayHelper;
use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
use common\models\base\BaseModel;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * @property int    $id   Идентификатор города
 * @property string $name Наименование города
 */
class City extends BaseModel
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
        return TableRegistry::NAME_CITY;
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
}
