<?php

namespace common\models\event;

use common\components\ArrayHelper;
use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\models\base\BaseModel;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * @property int    $id       Идентификатор даты проведения события
 * @property int    $event_id Идентификатор события
 * @property string $date     Дата проведения
 * @property int    $duration Продолжительность
 * @property Event  $event
 * @property array  $publicInfo
 */
class EventCarryingDate extends BaseModel
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
        return RgTable::NAME_EVENT_CARRYING_DATE;
    }

    public function getPublicInfo(): array
    {
        return [
            RgAttribute::ID       => $this->id,
            RgAttribute::DATE     => $this->date,
            RgAttribute::DURATION => $this->duration
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(
            Event::class,
            [
                RgAttribute::ID => RgAttribute::EVENT_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID       => Yii::t('app', 'ID'),
            RgAttribute::EVENT_ID => Yii::t('app', 'Event ID'),
            RgAttribute::DATE     => Yii::t('app', 'Date'),
            RgAttribute::DURATION => Yii::t('app', 'Duration'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    RgAttribute::EVENT_ID,
                    RgAttribute::DATE
                ],
                'required'
            ],
            [
                [
                    RgAttribute::EVENT_ID
                ],
                'integer'
            ],
            [
                [
                    RgAttribute::DATE,
                    RgAttribute::DURATION
                ],
                'safe'
            ],
            [
                [
                    RgAttribute::EVENT_ID
                ],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Event::class,
                'targetAttribute' => [
                    RgAttribute::EVENT_ID => RgAttribute::ID
                ]
            ],
        ];
    }
}
