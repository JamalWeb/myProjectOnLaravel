<?php

namespace common\models\event;

use common\components\ArrayHelper;
use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
        return TableRegistry::NAME_EVENT_CARRYING_DATE;
    }

    /**
     * @return ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(
            Event::class,
            [
                AttrRegistry::ID => AttrRegistry::EVENT_ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID       => Yii::t('app', 'ID'),
            AttrRegistry::EVENT_ID => Yii::t('app', 'Event ID'),
            AttrRegistry::DATE     => Yii::t('app', 'Date'),
            AttrRegistry::DURATION => Yii::t('app', 'Duration'),
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
                    AttrRegistry::EVENT_ID,
                    AttrRegistry::DATE
                ],
                'required'
            ],
            [
                [
                    AttrRegistry::EVENT_ID,
                    AttrRegistry::DURATION
                ],
                'default',
                'value' => null
            ],
            [
                [
                    AttrRegistry::EVENT_ID,
                    AttrRegistry::DURATION
                ],
                'integer'
            ],
            [
                [AttrRegistry::DATE],
                'safe'
            ],
            [
                [AttrRegistry::EVENT_ID],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Event::class,
                'targetAttribute' => [
                    AttrRegistry::EVENT_ID => AttrRegistry::ID
                ]
            ],
        ];
    }
}
