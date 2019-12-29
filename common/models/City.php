<?php

namespace common\models;

use common\components\ArrayHelper;
use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
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
        return RgTable::NAME_CITY;
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
}
