<?php

namespace common\models\event;

use common\components\ArrayHelper;
use common\models\base\BaseModel;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "event_type".
 *
 * @property int     $id   Идентификатор типа события
 * @property string  $name Наименование типа события
 * @property string  $desc Описание типа события
 * @property Event[] $events
 */
class EventType extends BaseModel
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
        return 'event_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        return $this->hasMany(Event::class, ['type_id' => 'id']);
    }
}
