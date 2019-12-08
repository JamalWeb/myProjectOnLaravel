<?php

namespace common\models\event;

use common\components\ArrayHelper;
use common\models\base\BaseModel;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "event_carrying_date".
 *
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
        return 'event_carrying_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'date'], 'required'],
            [['event_id', 'duration'], 'default', 'value' => null],
            [['event_id', 'duration'], 'integer'],
            [['date'], 'safe'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'event_id' => Yii::t('app', 'Event ID'),
            'date'     => Yii::t('app', 'Date'),
            'duration' => Yii::t('app', 'Duration'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }
}
