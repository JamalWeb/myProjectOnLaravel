<?php

namespace common\models\event;

use common\components\registry\RgAttribute;
use common\components\registry\RgTable;
use common\models\base\BaseModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * @property int    $id         Идентификатор фотографии
 * @property string $name       Наименование фотографии
 * @property int    $event_id   Идентификатор события
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 * @property Event  $event
 */
class EventPhotoGallery extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return RgTable::NAME_EVENT_PHOTO_GALLERY;
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
            RgAttribute::ID         => Yii::t('app', 'ID'),
            RgAttribute::NAME       => Yii::t('app', 'Name'),
            RgAttribute::EVENT_ID   => Yii::t('app', 'Event ID'),
            RgAttribute::CREATED_AT => Yii::t('app', 'Created At'),
            RgAttribute::UPDATED_AT => Yii::t('app', 'Updated At'),
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
                    RgAttribute::EVENT_ID
                ],
                'required'
            ],
            [
                [RgAttribute::EVENT_ID],
                'default',
                'value' => null
            ],
            [
                [RgAttribute::EVENT_ID],
                'integer'
            ],
            [
                [
                    RgAttribute::CREATED_AT,
                    RgAttribute::UPDATED_AT
                ],
                'safe'
            ],
            [
                [RgAttribute::NAME],
                'string',
                'max' => 255
            ],
            [
                [RgAttribute::EVENT_ID],
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
