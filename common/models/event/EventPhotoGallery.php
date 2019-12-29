<?php

namespace common\models\event;

use common\components\registry\AttrRegistry;
use common\components\registry\TableRegistry;
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
        return TableRegistry::NAME_EVENT_PHOTO_GALLERY;
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
            AttrRegistry::ID         => Yii::t('app', 'ID'),
            AttrRegistry::NAME       => Yii::t('app', 'Name'),
            AttrRegistry::EVENT_ID   => Yii::t('app', 'Event ID'),
            AttrRegistry::CREATED_AT => Yii::t('app', 'Created At'),
            AttrRegistry::UPDATED_AT => Yii::t('app', 'Updated At'),
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
                    AttrRegistry::EVENT_ID
                ],
                'required'
            ],
            [
                [AttrRegistry::EVENT_ID],
                'default',
                'value' => null
            ],
            [
                [AttrRegistry::EVENT_ID],
                'integer'
            ],
            [
                [
                    AttrRegistry::CREATED_AT,
                    AttrRegistry::UPDATED_AT
                ],
                'safe'
            ],
            [
                [AttrRegistry::NAME],
                'string',
                'max' => 255
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
