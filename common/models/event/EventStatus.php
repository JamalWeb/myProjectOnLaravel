<?php

namespace common\models\event;

use common\components\ArrayHelper;
use common\models\base\BaseModel;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "event_status".
 *
 * @property int     $id   Идентификатор статуса события
 * @property string  $name Наименование статуса события
 * @property string  $desc Описание статуса события
 * @property Event[] $events
 */
class EventStatus extends BaseModel
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
        return 'event_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'desc'], 'string', 'max' => 255],
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
            'desc' => Yii::t('app', 'Desc'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::class, ['status_id' => 'id']);
    }
}
