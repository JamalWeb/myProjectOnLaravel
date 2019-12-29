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
        return TableRegistry::NAME_EVENT_STATUS;
    }

    /**
     * @return ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(
            Event::class,
            [
                AttrRegistry::STATUS_ID => AttrRegistry::ID
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            AttrRegistry::ID          => Yii::t('app', 'ID'),
            AttrRegistry::NAME        => Yii::t('app', 'Name'),
            AttrRegistry::DESCRIPTION => Yii::t('app', 'Desc'),
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
                    AttrRegistry::NAME,
                    AttrRegistry::DESCRIPTION
                ],
                'string',
                'max' => 255
            ],
        ];
    }
}
