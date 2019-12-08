<?php

namespace common\models\event;

use common\models\base\BaseModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "event_photo_gallery".
 *
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
        return 'event_photo_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'event_id'], 'required'],
            [['event_id'], 'default', 'value' => null],
            [['event_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'name'       => Yii::t('app', 'Name'),
            'event_id'   => Yii::t('app', 'Event ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
