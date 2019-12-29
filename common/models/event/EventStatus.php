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
 * @property int     $id          Идентификатор статуса события
 * @property string  $name        Наименование статуса события
 * @property string  $description Описание статуса события
 * @property Event[] $events
 */
class EventStatus extends BaseModel
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
        return RgTable::NAME_EVENT_STATUS;
    }

    /**
     * @return ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(
            Event::class,
            [
                RgAttribute::STATUS_ID => RgAttribute::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            RgAttribute::ID          => Yii::t('app', 'ID'),
            RgAttribute::NAME        => Yii::t('app', 'Name'),
            RgAttribute::DESCRIPTION => Yii::t('app', 'Desc'),
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
                    RgAttribute::NAME,
                    RgAttribute::DESCRIPTION
                ],
                'string',
                'max' => 255
            ],
        ];
    }
}
